<template>
	<view class="wanl-goods">
		<!-- 导航条 -->
		<view class="cu-custom" :style="{ height: wanlsys.height + 'px' }">
			<view class="cu-bar fixed" :style="{ height: wanlsys.height + 'px', paddingTop: wanlsys.top + 'px' }">
				<view class="action" @tap="$wanlshop.back(1)"><text class="wlIcon-fanhui1"></text></view>
				<view class="search-form round">
					<text class="wlIcon-sousuo1 text-bold"></text>
					<swiper class="search-swiper placeholder" vertical autoplay circular interval="3000">
						<swiper-item @tap="productSearch('')">搜索商品、类目</swiper-item>
					</swiper>
				</view>
				<view class="action">
					<!-- #ifndef MP -->
					<text class="wlIcon-fenxiangcopy" @tap="showModal('share')"></text>
					<text class="wlIcon-liebiaomoshi" @tap="showModal('menu')"></text>
					<text class="wlIcon-31gouwuche" @tap="toCart"></text>
					<!-- #endif -->
				</view>
				
				<view class="bar-bg solid-bottom" :style="{ top: wanlsys.height + 'px', opacity: headerOpacity }">
					<scroll-view scroll-x class="nav">
						<view class="flex justify-around text-center">
							<view class="cu-item " :class="selectAnchor==index?'text-orange cur':''" v-for="(anchor, index) in anchorlist" :key="anchor.name" @tap="toAnchor(index)">
								{{ anchor.name }}
							</view>
						</view>
					</scroll-view>
				</view>
				<!-- 直播 -->
				<view class="wan-live" v-if="goodsData.isLive" @tap="onLive(goodsData.isLive.id)">
					<view class="tag shadow-blur" :style="{top:wanlsys.height + 47 + 'px' }">
						<view class="text-center">
							<view class="live">
								<view class="wanLive-icon"> </view>
							</view>
							<text class="text-white margin-lr-xs"> 在直播 </text>
						</view>
					</view>
				</view>
			</view>
		</view>
		
		<!-- 商品主图轮播 -->
		<view class="swiper-box" id="swiper">
			<swiper circular="true" autoplay="true" @change="swiperChange">
				<swiper-item v-for="(swiper, index) in goodsData.images" :key="index">
					<image :src="$wanlshop.oss(swiper, 400, 0)" mode="aspectFill"/>
				</swiper-item>
			</swiper>
			<view class="indicator">{{ currentSwiper + 1 }}/{{ goodsData.images.length }}</view>
		</view>
		<!-- 产品 -->
		<view class="bg-white">
			<!-- 普通 -->
			<view class="price margin-bottom-sm padding-lr-bj padding-top-bj align-start">
				<view>
					<view class="text-price wanl-orange text-xxl margin-right-xs">{{ goodsData.interval_price || '0.00' }}</view>
					<view class="text-sm wanl-gray text-dec">
						市场价
						<text class="text-price margin-left-xs ">{{ goodsData.market_price || 0.0 }}</text>
					</view>
				</view>
				<view class="follow wanl-black" v-if="goodsData.follow" @tap="follow">
					<text class="wlIcon-yiguanzhu1 text-red"></text>
					<text class="text-xs">取关</text>
				</view>
				<view class="follow wanl-black" v-else @tap="follow">
					<text class="wlIcon-gerenguanzhu"></text>
					<text class="text-xs">关注</text>
				</view>
			</view>
			<view class="title padding-lr-bj padding-bottom-bj">
				<view class="name wanl-black text-lg">
					<view v-if="goodsData.shop.isself == 1" class="cu-tag radius margin-right-xs sm bg-red">自营</view>
					{{ goodsData.title || '加载中...' }}
				</view>
				<view class="share" @tap="showModal('share')">
					<view class="button wanl-gray-light margin-bottom">
						<text class="wlIcon-fenxiangcopy margin-right-xs"></text>
						<text class="text-sm">分享</text>
					</view>
				</view>
			</view>

			<view class="block text-min padding-lr padding-bottom-bj">
				<view class="wanl-gray">
					<text class="wlIcon-weizhi margin-right-xs"></text>
					{{ goodsData.shop.city ? goodsData.shop.city.split('/')[1] : '中国' }}
				</view>
				<view class="wanl-gray">
					快递费：
					<text class="text-price">{{ goodsData.freight.price }}</text>
				</view>
				<view class="wanl-gray">
					月销
					<text class="margin-left-xs">{{ goodsData.sales }}</text>
				</view>
			</view>
		</view>
		<!-- 营销 -->
		<view class="promotion text-sm">
			<!-- <view class="item" @tap="showModal('promotion')">
				<view class="label wanl-gray">促销</view>
				<view class="conten">
					<view class="promotion-header">
						<text class="wlIcon-31daifahuo wanl-red margin-right-xs"></text>
						参加一下活动，预计可省 <text class="wanl-red text-price margin-lr-xs">10.00</text> 元
					</view>
					<view class="promotion-header">
						<view class="cu-tag sm line-orange round margin-right-xs">
							满80包邮
						</view>
						购物满80元包邮
					</view>
					<view class="promotion-header">
						<view class="cu-tag sm line-orange round margin-right-xs">
							满二送一
						</view>买满二个送一，买满五送三
					</view>
				</view>
				<view class="bnt-quan wanl-gray">
					更多<text class="wlIcon-fanhui2 margin-left-xs"></text>
				</view>
			</view> -->
			<view class="item" @tap="showModal('coupon')" v-if="goodsData.coupon.length != 0">
				<view class="label wanl-gray">领券</view>
				<view class="conten flex ">
					<view class="wanl-ticket text-sm" v-for="(item, index) in goodsData.coupon" :key="index" v-if="index < 2">
						<block v-if="item.type == 'reduction' || (item.type == 'vip' && item.usertype == 'reduction')">
							<view class="ticket-price"> ￥{{Number(item.price)}} </view>
							<view class="ticket-title"> <text>满{{Number(item.limit)}}减{{Number(item.price)}}</text> </view>
						</block>
						<block v-if="item.type == 'discount' || (item.type == 'vip' && item.usertype == 'discount')">
							<view class="ticket-price"> {{Number(item.discount)}}折 </view>
							<view class="ticket-title"> <text>满{{Number(item.limit)}}打{{Number(item.discount)}}折</text> </view>
						</block>
						<block v-if="item.type == 'shipping'">
							<view class="ticket-price"> 包邮 </view>
							<view class="ticket-title"> <text>满{{Number(item.limit)}}元包邮</text> </view>
						</block>
					</view>
				</view>
				<view class="bnt-quan wanl-gray">
					更多<text class="wlIcon-fanhui2 margin-left-xs"></text>
				</view>
			</view>
		</view>
		<!-- 选择商品 -->
		<view class="choice margin-bottom-bj padding-bj text-sm bg-white">
			<view class="commodity  margin-bottom-bj" @tap="showModal('option')">
				<view class="opt">
					<view class="title wanl-gray">选择</view>
					<view class="option">
						<view class="selected">
							<view v-if="canCount">
								选择
								<text class="margin-lr-xs" v-for="(item, index) in goodsData.spu" :key="item.id">{{ item.name }}</text>
							</view>
							<view v-else>
								已选
								<text>{{ selectArr.join(' / ') }}</text>
							</view>
						</view>
						<view class="option-list">
							<view v-for="(item, index) in goodsData.spu" :key="item.id">
								<text class="cu-tag" v-if="index == 0" v-for="tag in item.item" :key="tag.name">{{ tag.name }}</text>
								<text class="cu-tag" v-if="index == 0">更多规格可选</text>
							</view>
						</view>
					</view>
				</view>
				<view class="text-sm wanl-gray"><text class="wlIcon-fanhui2"></text></view>
			</view>
			<view class="commodity" @tap="showModal('service')">
				<view class="opt">
					<view class="title wanl-gray text-sm">服务</view>
					<view class="option">
						<view class="selected">
							<block v-for="(item, index) in goodsData.shop.service_ids" :key="item.id" v-if="index <= 2">
								<text class="margin-lr-xs" v-if="index != 0">·</text>
								{{ item.name }}
							</block>
						</view>
					</view>
				</view>
				<view class="text-min wanl-gray"><text class="wlIcon-fanhui2"></text></view>
			</view>
		</view>
		<!-- 产品参数 -->
		<view class="choice margin-bottom-bj padding-bj text-sm bg-white">
			<view class="commodity" @tap="showModal('attribute')">
				<view class="opt">
					<view class="title wanl-gray text-sm">参数</view>
					<view class="option">
						<view class="selected"><text>品牌、规格等...</text></view>
					</view>
				</view>
				<view class="text-min wanl-gray"><text class="wlIcon-fanhui2"></text></view>
			</view>
		</view>
		<!-- 评论 -->
		<view class="comment margin-bottom-bj padding-bj bg-white" id="evaluate">
			<view class="head" @tap="onTag('')">
				<view>商品评论({{ goodsData.comment }})</view>
				<view class="wanl-gray wanl-orange">
					{{ goodsData.comment > 0 ? parseInt((goodsData.praise / goodsData.comment) * 100) : 0 }}%好评率
					<text class="wlIcon-fanhui2 margin-left-xs"></text>
				</view>
			</view>
			<!-- 标签 -->
			<view class="label margin-bottom padding-bottom solid-bottom">
				<view @tap="onTag('good')" class="cu-tag round">好评 ({{ goodsData.praise }})</view>
				<view @tap="onTag('pertinent')" class="cu-tag round">中评 ({{ goodsData.moderate }})</view>
				<view @tap="onTag('poor')" class="cu-tag round">差评 ({{ goodsData.negative }})</view>
				<view @tap="onTag('figure')" class="cu-tag round">有图 ({{ goodsData.comment_list.figure }})</view>
				<view @tap="onTag(index)" v-for="(item, index) in goodsData.comment_list.tag" :key="index" class="cu-tag round">{{ index }} ({{ item }})</view>
			</view>
			<!-- 获取一个评论 -->
			<view class="user" v-for="(item, index) in goodsData.comment_list.data" :key="item.id"  @tap="onTag('')">
				<view class="userinfo">
					<view class="avatar">
						<view class="cu-avatar sm round margin-right-xs" :style="{ backgroundImage: 'url(' + $wanlshop.oss(item.user.avatar, 26, 26, 2, 'avatar') + ')' }"></view>
						<view class="text-sm wanl-gray">{{ item.user.nickname }}</view>
					</view>
					<wanl-rate :current="item.score" :disabled="true"></wanl-rate>
				</view>
			
				<view class="details text-min">
					<view class="margin-bottom-sm">{{ item.content }}</view>
					<view class="wanl-gray">规格：{{ item.suk }}</view>
				</view>
				<view class="grid flex-sub grid-square" :class="[item.images.length > 3 ? 'col-3' : 'col-' + item.images.length]" v-if="item.images.length != 0">
					<view
						class="bg-img"
						v-for="(image, index) in item.images"
						:key="index"
						v-if="index <= 3"
						:style="{ backgroundImage: 'url(' + $wanlshop.oss(image, 88, 88) + ')' }"
					></view>
				</view>
			</view>
			<!-- 查看更多 -->
			<view class="more" @tap="onTag('')"><text class="wanl-gray text-sm">查看全部</text><text class="wlIcon-fanhui4 margin-left-xs"></text></view>
		</view>
		<!-- 店铺 -->
		<view class="shop padding-bj solid-bottom bg-white">
			<view class="shopinfo margin-bottom">
				<view class="cu-avatar lg radius-bock" :style="{ backgroundImage: 'url(' + $wanlshop.oss(goodsData.shop.avatar, 52, 52, 2, 'avatar') + ')' }"></view>
				<view class="shopname">
					<view class="text-df">{{ goodsData.shop.shopname }}</view>
					<view class="wanl-gray text-min">{{ $wanlshop.toFormat(goodsData.shop.like, 'thousand') }} 人关注店铺</view>
				</view>
				<view class="bnt">
					<button class="cu-btn round line-orange margin-right-sm" @tap="onShop(goodsData.shop_id, 3)">全部商品</button>
					<button class="cu-btn round bg-gradual-orange" @tap="onShop(goodsData.shop_id)">进店逛逛</button>
				</view>
			</view>

			<view class="quality wanl-gray text-min">
				<view>
					商品描述
					<text class="">{{ goodsData.shop.score_describe }}</text>
					<view v-if="goodsData.shop.score_describe < 4.7" class="cu-tag round di">低</view>
					<view v-else class="cu-tag round gao">高</view>
				</view>
				<view>
					卖家服务
					<text class="wanl-orange">{{ goodsData.shop.score_service }}</text>
					<view v-if="goodsData.shop.score_service < 4.7" class="cu-tag round di">低</view>
					<view v-else class="cu-tag round gao">高</view>
				</view>
				<view>
					物流服务
					<text class="wanl-orange">{{ goodsData.shop.score_logistics }}</text>
					<view v-if="goodsData.shop.score_logistics < 4.7" class="cu-tag round di">低</view>
					<view v-else class="cu-tag round gao">高</view>
				</view>
			</view>
		</view>
		<!-- 店铺推荐 -->
		<view class="shop-recom padding-bj bg-white">
			<view class="head">
				<view class="">店铺推荐</view>
				<view class="text-sm wanl-orange" @tap="onShop(goodsData.shop_id, 1)">
					查看全部
					<text class="wlIcon-fanhui2 margin-left-xs"></text>
				</view>
			</view>
			<view class="recommend margin-bottom-xs">
				<view class="item" v-for="(item, index) in goodsData.shop_recommend" :key="item.id" @tap="onGoods(item.id)">
					<image :src="$wanlshop.oss(item.image, 125, 120)" mode="aspectFill"></image>
					<view class="text-sm margin-tb-xs text-cut">{{ item.title }}</view>
					<view class="text-price wanl-orange text-df">{{ item.price }}</view>
				</view>
			</view>
		</view>
		<!-- 分隔符 -->
		<wanl-divider width="60%">产品详情</wanl-divider>
		<!-- 产品详情 -->
		<view class="wanl-goods-content bg-white" id="details"><rich-text :nodes="goodsData.content"></rich-text></view>
		<!-- 分隔符 -->
		<wanl-divider width="60%">推荐商品</wanl-divider>
		<!-- 猜你喜欢 -->
		<view id="recommend">
			<wanl-product :dataList="likeData"/>
		</view>
		<uni-load-more :status="status" :content-text="contentText" />
		<view class="safeAreaBottom"></view>
		<view class="WANL-MODAL text-sm" @touchmove.stop.prevent="moveHandle">
			<!-- 顶部 -->
			<view class="cu-modal top-modal" :class="modalName == 'menu' ? 'show' : ''" @tap="hideModal">
				<view class="wanl-modal-menu cu-dialog" @tap.stop=""><wanl-direct @change="hideModal" /></view>
			</view>
			<!-- 促销 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'promotion' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog" @tap.stop="">
					<view class="wanl-modal">
						<view class="head padding-bj">
							<view class="content"><view class="text-lg">促销</view></view>
							<view class="close wlIcon-31guanbi" @tap="hideModal"></view>
						</view>
					</view>
				</view>
			</view>
			<!-- 优惠券 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'coupon' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog bg-bgcolor" @tap.stop="">
					<view class="wanl-modal">
						<view class="head padding-bj">
							<view class="content"><view class="text-lg">优惠券</view></view>
							<view class="close wlIcon-31guanbi" @tap="hideModal"></view>
						</view>
						<scroll-view class="wanl-coupon scroll-y" scroll-y="true">
							<view v-for="(coupon, index) in goodsData.coupon" :key="index" :class="coupon.type" class="item margin-bottom-bj radius-bock">
								<image :src="$wanlshop.appstc('/coupon/bg_coupon_3x.png')" class="coupon-bg"></image>
								<image :src="$wanlshop.appstc('/coupon/img_couponcentre_received_3x.png')" class="coupon-sign" v-if="coupon.state"></image>
								<view class="item-left">
									<block v-if="coupon.type == 'reduction' || (coupon.type == 'vip' && coupon.usertype == 'reduction')">
										<view class="colour">
											<text class="text-price"></text>
											<text class="prices">{{Number(coupon.price)}}</text>
										</view>
										<view class="cu-tag wanl-gray-dark radius text-sm bg-white">
											满{{Number(coupon.limit)}}减{{Number(coupon.price)}}
										</view>
									</block>
									<block v-if="coupon.type == 'discount' || (coupon.type == 'vip' && coupon.usertype == 'discount')">
										<view class="colour">
											<text class="prices">{{Number(coupon.discount)}}</text>
											<text class="discount">折</text>
										</view>
										<view class="cu-tag wanl-gray-dark radius text-sm bg-white">
											满{{Number(coupon.limit)}}打{{Number(coupon.discount)}}折
										</view>
									</block>
									<block v-if="coupon.type == 'shipping'">
										<view class="colour">
											<text class="prices">包邮</text>
										</view>
										<view class="cu-tag wanl-gray-dark radius text-sm bg-white">
											满{{Number(coupon.limit)}}元包邮
										</view>
									</block>
								</view>
								<view class="item-right padding-bj">
									<view class="title">
										<view class="cu-tag sm radius margin-right-xs tagstyle">
											{{coupon.type_text}}
										</view>
										<text class="text-cut wanl-gray text-min">{{coupon.name}}</text>
									</view>
									<view class="content text-min">
										<view class="wanl-gray">
											
											<view v-if="coupon.grant != '-1'">
												<text class="wlIcon-dot"></text>目前仅剩余 {{coupon.surplus}} 张
											</view>
											
											<view v-if="coupon.drawlimit != 0">
												<text class="wlIcon-dot"></text>每人仅限领取 {{coupon.drawlimit}} 张
											</view>
											<block v-if="coupon.pretype == 'fixed'">
												<view>
													<text class="wlIcon-dot"></text>生效 {{coupon.startdate}}
												</view>
												<view>
													<text class="wlIcon-dot"></text>结束 {{coupon.enddate}}
												</view>
											</block>
											<block v-if="coupon.pretype == 'appoint'">
												<view v-if="coupon.validity == 0">
													<text class="wlIcon-dot"></text>未使用前 永久 有效
												</view>
												<view v-else>
													<text class="wlIcon-dot"></text>领取后 {{coupon.validity}} 天有效
												</view>
											</block>
										</view>
										<view class="cu-btn sm round" @tap="onReceive(index)"  v-if="!coupon.state">
											<text>立即领取</text>
										</view>
									</view>
								</view>
							</view>
						</scroll-view>
						<view class="foot padding-lr-bj"><button class="cu-btn bg-gradual-orange round text-bold complete" @tap="hideModal">完成</button></view>
					</view>
				</view>
			</view>
			<!-- 产品参数 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'attribute' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog" @tap.stop="">
					<view class="wanl-modal">
						<view class="head padding-bj">
							<view class="content"><view class="text-lg">产品参数</view></view>
						</view>
						<scroll-view class="scroll-y" scroll-y="true">
							<view class="table solid-bottom">
								<view class="name wanl-gray">品牌</view>
								<view class="value">{{ goodsData.brand.name }}</view>
							</view>
							<view class="table solid-bottom" v-for="(item, index) in goodsData.category_attribute" :key="index">
								<view class="name wanl-gray">{{ index }}</view>
								<view class="value">{{ item }}</view>
							</view>
						</scroll-view>
						<view class="foot padding-lr-bj"><button class="cu-btn bg-gradual-orange round text-bold complete" @tap="hideModal">完成</button></view>
					</view>
				</view>
			</view>
			<!-- 分享 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'share' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog" @tap.stop="">
					<wanl-share 
						:scrollAnimation="scrollAnimation" 
						:shareTitle="goodsData.title" 
						:shareText="goodsData.description" 
						:image="$wanlshop.oss(goodsData.image,50, 50)" 
						:href="common.appConfig.domain + '/pages/product/goods?id='+ goodsData.id +'&QRtype=goods'"
					isReport @change="wanlShare"/>
				</view>
			</view>
			<!-- 服务 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'service' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog" @tap.stop="">
					<view class="wanl-modal">
						<view class="head padding-bj">
							<view class="content"><view class="text-lg">基础服务保障</view></view>
						</view>
						<view class="listbox padding-bj">
							<view v-for="(item, index) in goodsData.shop.service_ids" :key="item.id">
								<view class="name">
									{{ item.name }}
									<text class="wlIcon-fuwuxing"></text>
								</view>
								<view class="description wanl-gray text-min">{{ item.description }}</view>
							</view>
						</view>
						<view class="foot padding-lr-bj"><button class="cu-btn bg-gradual-orange round text-bold complete" @tap="hideModal">完成</button></view>
					</view>
				</view>
			</view>
			<!-- 规格 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'option' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog" @tap.stop="">
					<view class="option wanl-modal">
						<view class="head text-left padding-bj solid-bottom">
							<view
								class="cu-avatar radius-bock margin-right"
								:style="{ backgroundImage: 'url(' + $wanlshop.oss(goodsData.image, 100, 100) + ')' }"
							></view>
							<view class="">
								<view class="text-price wanl-orange text-xl">{{ selectshop.price || goodsData.interval_price }}</view>
								<view class="wanl-gray">
									库存
									<text class="margin-lr-xs">{{ selectshop.stock || 0 }}</text>
									件
								</view>
								<view class="text-sm">
									<view v-if="selectArr.join('')">已选择：{{ selectArr.join(' ') }}</view>
									<view v-else>
										请选择：
										<text class="wanl-gray-light" v-for="(item, index) in goodsData.spu" :key="item.id">
											<block v-if="index != 0">-</block>
											{{ item.name }}
										</text>
									</view>
								</view>
							</view>
							<view class="close wlIcon-31guanbi" @tap="hideModal"></view>
						</view>
						<scroll-view scroll-y="true">
							<view class="opt text-left padding-bj solid-bottom" v-for="(value, spukey) in goodsData.spu" :key="value.id">
								<view class="text-df">{{ value.name }}</view>
								<view class="tag">
									<view
										class="cu-tag text-sm"
										v-for="(item, index) in value.item"
										:key="index"
										:class="[item.ishow ? '' : 'noactive', subIndex[spukey] == index ? 'active' : '']"
										@tap="skuClick(item, spukey, $event, index)"
									>
										{{ item.name }}
									</view>
								</view>
							</view>
							<view class="number padding-bj">
								<view class="text-df">购买数量</view>
								<uni-number-box :min="1" :max="selectshop.stock" :value="selectNum" :disabled="canCount" @change="changeNum"></uni-number-box>
							</view>
						</scroll-view>

						<view class="foot padding-lr-bj">
							<button v-if="isChoice" class="cu-btn bg-gradual-orange round text-bold complete" @tap="completeSelection">完成</button>
							<block v-else>
								<button class="cu-btn bg-gradual-yellow round-left text-bold" @tap="SubmitData('addToCart', 1)">加入购物车</button>
								<button class="cu-btn bg-gradual-orange round-right text-bold" @tap="SubmitData('placeOrder', 1)">立即订购</button>
							</block>
						</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 底部 -->
		<view class="wanlian cu-bar tabbar shop solid-top foot">
			<view class="action" @tap="onShop(goodsData.shop_id)">
				<view class="wlIcon-dianpu1 wanl-orange"></view>
				店铺
			</view>
			<view class="action" @tap="toCart">
				<view class="wlIcon-gouwuche">
					<view class="cu-tag badge" v-if="cart.cartnum > 0">{{ cart.cartnum }}</view>
				</view>
				购物车
			</view>
			<!-- 1.0.2升级 -->
			<view class="action" @tap="toChat(goodsData.shop_id, { id: goodsData.id, title: goodsData.title, image: goodsData.image, price: goodsData.price })">
				<view class="wlIcon-kefu"><view class="cu-tag badge"></view></view>
				客服
			</view>
			<view class="btn-group">
				<button class="cu-btn bg-gradual-yellow round-left" @tap="SubmitData('addToCart')">加入购物车</button>
				<button class="cu-btn bg-gradual-orange round-right" @tap="SubmitData('placeOrder')">立即购买</button>
			</view>
		</view>
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			TabCur: 0,
			wanlsys: this.$wanlshop.wanlsys(),
			modalName: null, // 弹出层
			durect: 0, // 角标
			headerOpacity: 0, //不透明度
			currentSwiper: 0, // 轮播图右下角数字
			anchorlist: [{ name: '主图', top: 0 }, { name: '评价', top: 0 }, { name: '详情', top: 0 }, { name: '推荐', top: 0 }], //导航条锚点
			selectAnchor: 0,
			//产品数据
			goodsData: {
				id: 0,
				category_id: 0,
				shop_id: 0,
				brand_id: 0,
				freight_id: 0,
				title: '',
				image: '',
				images: '',
				flag: '',
				content: '',
				category_attribute: [],
				activity: false,
				price: null,
				interval_price: null,
				market_price: null,
				sales: 0,
				brand: {},
				freight: {
					name: '',
					isdelivery: 1
				},
				payment: 0,
				comment: 0,
				praise: 0,
				moderate: 0,
				negative: 0,
				like: 0,
				views: 0,
				status: '',
				category: {},
				follow: true,
				sku: [],
				spu: [],
				promotion: [],
				coupon: [],
				comment_list: {
					data: [],
					figure: 0,
					tag: []
				},
				shop: {
					city: ''
				},
				shop_recommend: {}
			},
			// 猜你喜欢
			reload: true,
			likeData: [],
			current_page: 1, //当前页码
			last_page: 1, //总页码
			status: 'loading',
			contentText: {
				contentdown: ' ',
				contentrefresh: '正在加载...',
				contentnomore: '没有更多数据了'
			},
			// 商品规格组合
			shopItemInfo: {}, //存放要和选中的值进行匹配的数据
			selectArr: [], //存放被选中的值
			subIndex: [], //是否选中 因为不确定是多规格还是但规格，所以这里定义数组来判断
			selectshop: {}, //存放最后选中的商品
			selectNum: 1, //选中数量
			isChoice: '', // 是否从选择进入
			scrollAnimation: 0 //分享滚动
		};
	},
	onLoad(option) {
		this.loadData(option);
		this.loadlikeData();
		// #ifdef MP-WEIXIN
		wx.showShareMenu({
			withShareTicket: true,
			menus: ['shareAppMessage', 'shareTimeline']
		});
		// #endif
		this.durect =
			this.$store.state.statistics.notice.notice +
			this.$store.state.statistics.notice.order +
			this.$store.state.statistics.notice.chat +
			this.$store.state.statistics.order.pay +
			this.$store.state.statistics.order.delive +
			this.$store.state.statistics.order.receiving +
			this.$store.state.statistics.order.evaluate;
	},
	onPageScroll(e) {
		//导航栏渐变
		let tmpY = 150;
		e.scrollTop = e.scrollTop > tmpY ? 150 : e.scrollTop; //如果当前高度大于250则250否则当前高度
		this.headerOpacity = e.scrollTop * (1 / tmpY); //$headerOpacity 赋值当前高度x（1÷250）
	},
	onReachBottom() {
		//判断是否最后一页
		if (this.current_page >= this.last_page) {
			this.status = 'noMore';
		} else {
			this.reload = false;
			this.current_page = this.current_page + 1; //页码+1
			this.status = 'loading';
			this.loadlikeData();
		}
	},
	watch: {
	    selectshop(n, o) {
			if(n.price != o.price){
				// 更新一次优惠券
				this.queryCoupon(n.price);
			}
	    }
	},
	computed: {
		canCount() {
			return this.subIndex.some(item => item === -1);
		},
		...mapState(['cart', 'common'])
	},
	methods: {
		async loadData(option) {
			//加载商品
			this.$api.get({
				url: '/wanlshop/product/goods',
				data: option,
				success: res => {
					//详情正则
					res.content = res.content.replace(/<img [^>]*src=['"]([^'"]+)[^>]*>/gi, (match, capture) => {
						var img = `<img style="display: block; max-width: 100%;" src="${this.$wanlshop.oss(capture, 500, 0)}">`;
						return img;
					});
					// 价格区间
					if (res.sku.length == 0) {
						res.interval_price = res.price;
						res.market_price = res.price;
					}else{
						let price = [],
							market_price = [];
						for (let value of res.sku) {
							price.push(value.price);
							market_price.push(value.market_price);
						}
						let minPrice = Math.min.apply(null, price),
							maxPrice = Math.max.apply(null, price),
							maxMarketPrice = Math.max.apply(null, market_price);
						res.interval_price = minPrice == maxPrice ? minPrice : minPrice + '-' + maxPrice; //区间价格
						res.market_price = Number(maxMarketPrice).toFixed(2); //最大市场价
					}
					this.goodsData = res;
					// 商品规格组合
					this.goodsData.spu.map(item => {
						this.selectArr.push('');
						this.subIndex.push(-1);
					});
					this.checkItem(); //计算sku里面规格形成路径
					this.checkInpath(-1); //传-1是为了不跳过循环
					// 计算锚点高度
					setTimeout(() => {
						this.calcAnchor();
					}, 1000);
				}
			});
		},
		// 滚动底部加载猜你喜欢
		async loadlikeData() {
			this.$api.get({
				url: '/wanlshop/product/likes?pages=goods',
				data: {
					page: this.current_page
				},
				success: res => {
					this.likeData = this.reload ? res.data : this.likeData.concat(res.data); //评论数据 追加
					this.current_page = res.current_page; //当前页码
					this.last_page = res.last_page; //总页码
					this.status = 'more';
				}
			});
		},
		// 查询优惠券，减缓服务器压力，单独查询
		async queryCoupon(price) {
			this.$api.post({
				url: '/wanlshop/coupon/query',
				data: {
					shop_id: this.goodsData.shop_id,
					goods_id: this.goodsData.id,
					shop_category_id: this.goodsData.shop_category_id,
					price: price
				},
				success: res => {
					this.goodsData.coupon = res;
				}
			});
		},
		// 领取优惠券
		async onReceive(index) {
			let coupon = this.goodsData.coupon[index];
			this.$api.post({
				url: '/wanlshop/coupon/receive',
				loadingTip: '领取中',
				data: {
					id: coupon.id
				},
				success: res => {
					coupon.id = res.id;
					coupon.state = true;
					this.$wanlshop.msg(res.msg);
					// 更新状态管理器
					this.$store.commit('statistics/dynamic', {
						coupon: this.$store.state.statistics.dynamic.coupon + 1
					});
				}
			});
		},
		// 商品规格组合 选择
		skuClick(value, spukey, event, index) {
			if (value.ishow) {
				if (this.selectArr[spukey] != value.name) {
					this.$set(this.selectArr, spukey, value.name);
					this.$set(this.subIndex, spukey, index);
				} else {
					this.$set(this.selectArr, spukey, '');
					this.$set(this.subIndex, spukey, -1);
				}
				this.checkInpath(spukey);
				//如果全部选完
				if (this.selectArr.every(item => item != '')) {
					this.selectshop = this.shopItemInfo[this.selectArr];
					this.selectNum = 1;
				}
			}
		},
		//循环所有属性判断哪些属性可选
		checkInpath(clickIndex) {
			
			//当前选中的兄弟节点和已选中属性不需要循环
			for (let i = 0, len = this.goodsData.spu.length; i < len; i++) {
				if (i == clickIndex) {
					continue;
				}
				let len2 = this.goodsData.spu[i].item.length;
				for (let j = 0; j < len2; j++) {
					if (this.subIndex[i] != -1 && j == this.subIndex[i]) {
						continue;
					}
					let choosed_copy = [...this.selectArr];
					this.$set(choosed_copy, i, this.goodsData.spu[i].item[j].name);
					let choosed_copy2 = choosed_copy.filter(item => item !== '' && typeof item !== 'undefined');
					if (this.shopItemInfo.hasOwnProperty(choosed_copy2)) {
						this.$set(this.goodsData.spu[i].item[j], 'ishow', true);
					} else {
						this.$set(this.goodsData.spu[i].item[j], 'ishow', false);
					}
				}
			}
			// console.log(this.goodsData.spu)
		},
		//计算有多小种可选路径
		checkItem() {
			let result = this.goodsData.sku.reduce(
				(arrs, items) => {
					return arrs.concat(
						items.difference.reduce(
							(arr, item) => {
								return arr.concat(
									arr.map(item2 => {
										//利用对象属性的唯一性实现二维数组去重
										if (!this.shopItemInfo.hasOwnProperty([...item2, item])) {
											this.shopItemInfo[[...item2, item]] = items;
										}
										return [...item2, item];
									})
								);
							},
							[[]]
						)
					);
				},
				[[]]
			);
		},
		//商品规格修改数量
		changeNum(val) {
			this.selectNum = parseInt(val);
		},
		//轮播图指示器
		swiperChange(e) {
			this.currentSwiper = e.detail.current;
		},
		// 弹出层
		showModal(name) {
			this.isChoice = '';
			// 滚动下分享
			if (name == 'share' && this.modalName != 'share') {
				setTimeout(() => {
					this.scrollAnimation = 0;
				}, 300);
			}
			this.modalName = name;
		},
		// 关闭弹出层
		hideModal(name) {
			if (name) {
				this.showModal(name);
			} else {
				this.modalName = null;
			}
		},
		// 分享回调
		wanlShare(e){
			if(e){
				this.$wanlshop.auth(`/pages/user/complaint/complaint?id=${this.goodsData.id}&type=1`);
			}else{
				this.modalName = null;
			}
		},
		//禁止父元素滑动
		moveHandle() {},
		// 关注 & 取消
		follow() {
			this.goodsData.follow = !this.goodsData.follow;
			// 全局控制中心
			if (this.goodsData.follow) {
				this.$store.commit('statistics/dynamic', {
					collection: this.$store.state.statistics.dynamic.collection + 1
				});
			} else {
				this.$store.commit('statistics/dynamic', {
					collection: this.$store.state.statistics.dynamic.collection - 1
				});
			}
			this.$api.post({
				url: '/wanlshop/product/follow',
				data: {
					id: this.goodsData.id
				},
				success: res => {
					this.goodsData.follow = res;
				}
			});
		},
		//跳转锚点
		toAnchor(index) {
			this.selectAnchor = index;
			uni.pageScrollTo({
				scrollTop: this.anchorlist[index].top,
				duration: 200
			});
		},
		//计算锚点高度
		calcAnchor() {
			let query = null;
			// 支付宝小程序不能加后面的.in(this)，是它自身的限制
			// #ifndef MP-ALIPAY
			query = uni.createSelectorQuery().in(this)
			// #endif
			// #ifdef MP-ALIPAY
			query = uni.createSelectorQuery()
			// #endif
			query.select('#evaluate').boundingClientRect(rec => {
				this.anchorlist[1].top = rec.top - this.wanlsys.height - 45;
			}).exec();
			query.select('#details').boundingClientRect(rec => {
				this.anchorlist[2].top = rec.top - this.wanlsys.height - 45;
			}).exec();
			query.select('#recommend').boundingClientRect(rec => {
				this.anchorlist[3].top = rec.top - this.wanlsys.height - 45;
			}).exec();
		},
		// 评论页
		onTag(tag) {
			this.$wanlshop.to('/pages/product/comment?id=' + this.goodsData.id + '&praise=' + this.goodsData.praise + '&tag=' + tag);
		},
		// 打开购物车
		toCart() {
			uni.switchTab({ url: '/pages/cart/cart' });
		},
		// 完成选择
		completeSelection() {
			if (this.canCount) {
				this.$wanlshop.msg('请选择完成规格');
			} else {
				this.ProcessingData();
			}
		},
		// 提交数据
		SubmitData(name, type) {
			// if (!this.subIndex[0]) {
				// this.$wanlshop.msg('客官先别急，系统还在加载');
			// } else {
				
			// }
			if(type == 1){
				if (this.canCount) {
					this.$wanlshop.msg('请选择完成规格');
				}else{
					this.isChoice = name;
					this.ProcessingData();
				}
			}else{
				this.modalName = 'option';
				this.isChoice = name;
			}
		},
		ProcessingData() {
			if (this.isChoice == 'addToCart') {
				this.$store.dispatch('cart/add', {
					shop_id: this.goodsData.shop_id,
					shop_name: this.goodsData.shop.shopname,
					goods_id: this.goodsData.id,
					title: this.goodsData.title,
					number: this.selectNum,
					image: this.goodsData.image,
					sku: this.selectshop,
					sku_id: this.selectshop.id,
					sum: this.$wanlshop.bcmul(this.selectshop.price, this.selectNum)
				});
				this.$wanlshop.msg('已加购物车');
			} else if (this.isChoice == 'placeOrder') {
				let goodsData = [
					{
						goods_id: this.goodsData.id,
						number: this.selectNum,
						sku_id: this.selectshop.id
					}
				];
				// 提交订单
				if (this.$store.state.user.isLogin) {
					uni.redirectTo({
						url: `/pages/user/order/addorder?type=goods&data=${JSON.stringify(goodsData)}`
					});
				}else{
					this.$wanlshop.to('/pages/user/auth/auth');
				}
				
			} else {
				this.$wanlshop.msg('数据异常');
			}
			this.hideModal();
		},
		productSearch(text) {
			this.$wanlshop.to(`/pages/product/search?keywords=${text}`, 'fade-in', 100);
		}
	}
};
</script>

<style>
toast,
uni-toast {
	z-index: 9999;
}
.cu-custom .cu-bar .search-form {
	background-color: #fff;
}

.cu-custom .cu-bar {
	background-color: #f3f3f3;
}

.cu-custom .bar-bg {
	background-color: rgba(243, 243, 243, 0.96);
}
.cu-custom .cu-bar {
	z-index: 99;
}
/* #ifdef MP */
.cu-custom .cu-bar .search-form {
	margin: 0 0 0 25rpx;
}
/* #endif */

.cu-custom .cu-bar .nav .cu-item{
	line-height: 70rpx;
	height: 70rpx;
}
.swiper-box {
	position: relative;
	width: 100%;
	height: 100vw;
}

.swiper-box swiper {
	width: 100%;
	height: 100vw;
}

.swiper-box swiper swiper-item image {
	width: 100%;
	height: 100vw;
}

.swiper-box .indicator {
	display: flex;
	justify-content: center;
	align-items: center;
	padding: 0 25upx;
	height: 40upx;
	border-radius: 40upx;
	font-size: 22upx;
	position: absolute;
	bottom: 20upx;
	right: 20upx;
	color: #fff;
	background-color: rgba(0, 0, 0, 0.2);
}
</style>
