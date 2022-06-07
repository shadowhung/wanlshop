<?phpnamespace app\admin\model\wanlshop;use think\Model;class Withdraw extends Model{            // 表名    protected $name = 'withdraw';        // 自动写入时间戳字段    protected $autoWriteTimestamp = 'int';    // 定义时间戳字段名    protected $createTime = 'createtime';    protected $updateTime = 'updatetime';    protected $deleteTime = false;    // 追加属性    protected $append = [        'status_text',        'transfertime_text'    ];	public function getTypeAttr($value)	{	    return [            "A001" => "南銀行株式会社",            "A002" => "三菱東京UFJ銀行",            "A003" => "三井住友銀行",            "A004" => "リカ銀行株式会社",            "A005" => "埼玉理華銀行株式会社",            "A006" => "北海道銀行",            "A007" => "青森銀行株式会社",            "A008" => "宮野銀行株式会社",            "A009" => "秋田銀行株式会社",            "A010" => "北東銀行株式会社",            "A011" => "総内銀行",            "A012" => "山形銀行株式会社",            "A013" => "岩手銀行株式会社",            "A014" => "東北銀行株式会社",            "A015" => "セブン銀行株式会社",            "A016" => "東邦銀行株式会社",            "A017" => "群馬銀行株式会社",            "A018" => "足利銀行株式会社",            "A019" => "長陽銀行株式会社",            "A020" => "つくば株式会社銀行",            "A021" => "武蔵野銀行",            "A022" => "千葉銀行",            "A023" => "千葉興業銀行",            "A024" => "東京メトロポリタン銀行株式会社",            "A025" => "横浜銀行",            "A026" => "株式会社フォースバンク",            "A027" => "北ベトナム銀行株式会社",            "A028" => "山梨中央銀行",            "A029" => "株式会社82銀行",            "A030" => "北陸銀行株式会社",            "A031" => "富山銀行",            "A032" => "ノースランド銀行株式会社",            "A033" => "福井銀行株式会社",            "A034" => "静岡銀行株式会社",            "A035" => "サージバンク株式会社",            "A036" => "清水銀行",            "A037" => "大垣共立銀行株式会社",            "A038" => "株式会社シックスティーンバンク",            "A039" => "三重銀行株式会社",            "A040" => "百五銀行株式会社",            "A041" => "滋賀銀行株式会社",            "A042" => "京東株式会社",            "A043" => "近畿大阪銀行",            "A044" => "池田泉州銀行",            "A045" => "南都銀行株式会社",            "A046" => "紀陽銀行株式会社",            "A047" => "但馬銀行株式会社",            "A048" => "鳥取銀行",            "A049" => "三人契約銀行株式会社",            "A050" => "中国銀行株式会社",            "A051" => "広島銀行株式会社",            "A052" => "山口銀行株式会社",            "A053" => "阿波銀行株式会社",            "A054" => "百十四銀行株式会社",            "A055" => "伊予銀行",            "A056" => "四国銀行",            "A057" => "福岡銀行",            "A058" => "筑波銀行株式会社",            "A059" => "佐賀銀行株式会社",            "A060" => "18銀行株式会社",            "A061" => "アフィニティバンク株式会社",            "A062" => "肥後銀行株式会社",            "A063" => "大分銀行",            "A064" => "宮崎銀行",            "A065" => "鹿児島銀行",            "A066" => "琉球銀行",            "A067" => "沖縄銀行株式会社",            "A068" => "西日本銀行株式会社",            "A069" => "北九州銀行株式会社",		][$value];	}        public function getStatusList()    {        return ['created' => __('Status created'), 'successed' => __('Status successed'), 'rejected' => __('Status rejected')];    }    public function getStatusTextAttr($value, $data)    {        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');        $list = $this->getStatusList();        return isset($list[$value]) ? $list[$value] : '';    }    public function getTransfertimeTextAttr($value, $data)    {        $value = $value ? $value : (isset($data['transfertime']) ? $data['transfertime'] : '');        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;    }    protected function setTransfertimeAttr($value)    {        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);    }}