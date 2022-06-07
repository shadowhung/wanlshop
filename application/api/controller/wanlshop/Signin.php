<?php
namespace app\api\controller\wanlshop;

use app\common\controller\Api;
use fast\Date;
use think\Db;
use think\Exception;
use think\exception\PDOException;

/**
 * WanlShop簽到接口
 */
class Signin extends Api
{
    protected $noNeedLogin = [];
    protected $noNeedRight = ['*'];
    
   
	/**
	 * 獲取簽到
	 *
	 * @ApiSummary  (WanlShop 獲取簽到)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $date 日期 2020-06-05
	 */
	public function getSignin()
	{
	    $config = get_addon_config('signin');
		if(!$config){
			$this->error('サインインプラグインは存在しません！ 公式リリースサインインプラグインをインストールしてください');
		}
	    $signdata = $config['signinscore'];
	    $date = $this->request->request('date', date("Y-m-d"), "trim");
	    $time = strtotime($date);
	    $lastdata = \addons\signin\model\Signin::where('user_id', $this->auth->id)->order('createtime', 'desc')->find();
	    $successions = $lastdata && $lastdata['createtime'] > Date::unixtime('day', -1) ? $lastdata['successions'] : 0;
	    $signin = \addons\signin\model\Signin::where('user_id', $this->auth->id)->whereTime('createtime', 'today')->find();
	    $list = \addons\signin\model\Signin::where('user_id', $this->auth->id)
	        ->field('id,createtime')
	        ->whereTime('createtime', 'between', [date("Y-m-1", $time), date("Y-m-1", strtotime("+1 month", $time))])
	        ->select();
			
		// 用戶積分
		$data['user_score'] = $this->auth->score;
		// 已簽到日期
		$data['list'] = $list;
		// 今日
		$data['date'] = $date;
		// 補簽時消耗的積分
		$data['fillupscore'] = $config['fillupscore'];
		// 是否可以補簽
		$data['isfillup'] = $config['isfillup'];
		// 妳當前已經連續簽到
		$data['successions'] = $successions; 
	    $successions++;
	    $score = isset($signdata['s' . $successions]) ? $signdata['s' . $successions] : $signdata['sn'];
		// 是否簽到
		$data['signin'] = $signin;
		// 可獲得積分
		$data['score'] = $score;
		// 連續第幾日
		$data['signinscore'] = $config['signinscore'];
		$this->success('OK', $data);
	}
	
	
	/**
	 * 立即簽到
	 *
	 * @ApiSummary  (WanlShop 獲取簽到)
	 * @ApiMethod   (POST)
	 * 
	 */
	public function dosign()
	{
	    if ($this->request->isPost()) {
	        $config = get_addon_config('signin');
	        $signdata = $config['signinscore'];
	
	        $lastdata = \addons\signin\model\Signin::where('user_id', $this->auth->id)->order('createtime', 'desc')->find();
	        $successions = $lastdata && $lastdata['createtime'] > Date::unixtime('day', -1) ? $lastdata['successions'] : 0;
	        $signin = \addons\signin\model\Signin::where('user_id', $this->auth->id)->whereTime('createtime', 'today')->find();
	        if ($signin) {
	            $this->error('今日サインインしました、明日戻ってきてください!');
	        } else {
	            $successions++;
	            $score = isset($signdata['s' . $successions]) ? $signdata['s' . $successions] : $signdata['sn'];
	            Db::startTrans();
	            try {
	                \addons\signin\model\Signin::create(['user_id' => $this->auth->id, 'successions' => $successions, 'createtime' => time()]);
	                \app\common\model\User::score($score, $this->auth->id, "継続的なチェックイン{$successions}日");
	                Db::commit();
	            } catch (Exception $e) {
	                Db::rollback();
	                $this->error('サインインに失敗しました。しばらくしてからもう一度お試しください');
	            }
	            $this->success('OK','サインイン成功！継続的なサインイン' . $successions . '日!入手します' . $score . '積分');
	        }
	    }
	    $this->error("リクエストエラー");
	}
	
	/**
	 * 簽到補簽
	 *
	 * @ApiSummary  (WanlShop 簽到補簽)
	 * @ApiMethod   (GET)
	 * 
	 * @param string $date 日期 2020-06-05
	 */
	public function fillup()
	{
	    $date = $this->request->request('date');
	    $time = strtotime($date);
	    $config = get_addon_config('signin');
	    if (!$config['isfillup']) {
	        $this->error('サインインの更新は開始されていません');
	    }
	    if ($time > time()) {
	        $this->error('将来の日付に再署名することはできません');
	    }
	    if ($config['fillupscore'] > $this->auth->score) {
	        $this->error('あなたの現在のポイントは不十分です');
	    }
	    $days = Date::span(time(), $time, 'days');
	    if ($config['fillupdays'] < $days) {
	        $this->error("再訪のみを許可する{$config['fillupdays']}日サインイン");
	    }
	    $count = \addons\signin\model\Signin::where('user_id', $this->auth->id)
	        ->where('type', 'fillup')
	        ->whereTime('createtime', 'between', [Date::unixtime('month'), Date::unixtime('month', 0, 'end')])
	        ->count();
	    if ($config['fillupnumsinmonth'] <= $count) {
	        $this->error("毎月の更新のみが許可されています{$config['fillupnumsinmonth']}タイムズ");
	    }
	    Db::name('signin')->whereTime('createtime', 'd')->select();
	    $signin = \addons\signin\model\Signin::where('user_id', $this->auth->id)
	        ->where('type', 'fillup')
	        ->whereTime('createtime', 'between', [$date, date("Y-m-d 23:59:59", $time)])
	        ->count();
	    if ($signin) {
	        $this->error("この日にサインインする必要はありません");
	    }
	    $successions = 1;
	    $prev = $signin = \addons\signin\model\Signin::where('user_id', $this->auth->id)
	        ->whereTime('createtime', 'between', [date("Y-m-d", strtotime("-1 day", $time)), date("Y-m-d 23:59:59", strtotime("-1 day", $time))])
	        ->find();
	    if ($prev) {
	        $successions = $prev['successions'] + 1;
	    }
	    Db::startTrans();
	    try {
	        \app\common\model\User::score(-$config['fillupscore'], $this->auth->id, 'サインイン');
	        //尋找日期之後的
	        $nextList = \addons\signin\model\Signin::where('user_id', $this->auth->id)
	            ->where('createtime', '>=', strtotime("+1 day", $time))
	            ->order('createtime', 'asc')
	            ->select();
	        foreach ($nextList as $index => $item) {
	            //如果是階段數據，則中止
	            if ($index > 0 && $item->successions == 1) {
	                break;
	            }
	            $day = $index + 1;
	            if (date("Y-m-d", $item->createtime) == date("Y-m-d", strtotime("+{$day} day", $time))) {
	                $item->successions = $successions + $day;
	                $item->save();
	            }
	        }
	        \addons\signin\model\Signin::create(['user_id' => $this->auth->id, 'type' => 'fillup', 'successions' => $successions, 'createtime' => $time + 43200]);
	        Db::commit();
	    } catch (PDOException $e) {
	        Db::rollback();
	        $this->error('辞任に失敗しました。しばらくしてからもう一度お試しください');
	    } catch (Exception $e) {
	        Db::rollback();
	        $this->error('辞任に失敗しました。しばらくしてからもう一度お試しください');
	    }
	    $this->success('OK','補の簽は成功します');
	}
	
	/**
	 * 排行榜
	 *
	 * @ApiSummary  (WanlShop 簽到補簽)
	 * @ApiMethod   (GET)
	 * 
	 */
	public function rank()
	{

		$config = get_addon_config('signin');

		if(!$config){

			$this->error('サインインプラグインは存在しません！ 公式リリースサインインプラグインをインストールしてください');

		}
	    $data = \addons\signin\model\Signin::with(["user"])
	        ->where("createtime", ">", Date::unixtime('day', -1))
	        ->field("user_id,MAX(successions) AS days")
	        ->group("user_id")
	        ->order("days", "desc")
	        ->limit(10)
	        ->select();
	    foreach ($data as $index => $datum) {
	        $datum->getRelation('user')->visible(['id', 'username', 'nickname', 'avatar', 'score']);
	    }
	    $this->success("OK", ['ranklist' => collection($data)->toArray()]);
	}
	
}
