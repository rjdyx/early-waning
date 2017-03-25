/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2016/12/14
 * 
 */
<template>
    <div>
        <tab :line-width=2 custom-bar-width="70px" active-color='#04be02' v-model="index">
            <tab-item class="vux-center" :selected="selectedItem === item" v-for="(item, index) in list" @on-item-click="tabClick(item)" :key="index">{{item}}</tab-item>
        </tab>
        <swiper v-model="index" :show-dots="false" class="swiper">
            <swiper-item :key="0">
                <ul class="event-list event-list-1">
                    <li @click="goDetail(item)" v-for="item in earlyWaningData">
                        <div class="left">
                            <h3>{{item.name}}</h3>
                            <p>{{item.location}}</p>
                        </div>
                        <div class="right">{{item.status | eventStatus}}</div>
                    </li>
                </ul>
            </swiper-item>
            <swiper-item :key="1">
                <ul class="event-list event-list-2">
                    <li @click="goDetail(item)" v-for="item in emergencyData">
                        <div class="left">
                            <h3>{{item.name}}</h3>
                            <p>{{item.location}}</p>
                        </div>
                        <div class="right">{{item.status | eventStatus}}</div>
                    </li>
                </ul>
            </swiper-item>
        </swiper>
    </div>
</template>
<style lang="sass" scoped>
    .swiper {
        margin-bottom: 1px;
    }

    .event-list {

        font-size: 14px;

        li {
            overflow: hidden;
            background: linear-gradient(180deg,#e5e5e5,#e5e5e5,hsla(0,0%,90%,0)) 0 100% no-repeat;
            background-size: 100% 1px;

            .left {
                float: left;
                padding: 10px;

                h3 {
                    width: 200px;
                    margin-bottom: 6px;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    overflow: hidden;
                    word-break: keep-all;
                }

                p {
                    width: 230px;
                    font-size: 13px;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    overflow: hidden;
                    word-break: keep-all;
                }
            }

            .right {
                float: right;
                padding: 10px;
            }
        }
    }
</style>
<script>

    import { Tab, TabItem, Swiper, SwiperItem } from 'vux'
    import { mapGetters, mapMutations } from 'vuex'

    export default{
        name:'List',
        data () {
            return {
                list: ['预警事件', '突发事件'],
                index: 0
            }
        },
        computed: {
            ...mapGetters([
                'earlyWaningData',
                'emergencyData',
                'selectedItem'
            ])
        },
        components: {
            Tab, 
            TabItem,
            Swiper, 
            SwiperItem
        },
        mounted () {
            this.setShowBack(false)
            this.setMenu([
                {
                    label: '退出登录',
                    value: 'logout'
                }
            ])
            this.getEvents()
            
        },
        methods: {

            ...mapMutations([
                'setShowBack',
                'setMenu',
                'setEarlyWaningData',
                'setEmergencyData',
                'setFormMsg',
                'setSelectedItem'
            ]),

            getEvents (status=[2,3]) {
                axios.get(this.$adminUrl('event/appQuery'), {params: {status: status}})
                    .then((responce) => {
                        if(status[0] == 2) {
                            this.setEarlyWaningData(responce.data)
                        }else {
                            this.setEmergencyData(responce.data)
                        }

                        if(this.earlyWaningData.length > this.emergencyData.length) {
                            $('.vux-swiper').css('height', this.earlyWaningData.length * 66 + 'px')
                        }else {
                            $('.vux-swiper').css('height', this.emergencyData.length * 66 + 'px')
                        }
                        
                    })
            },

            goDetail (item) {
                this.setFormMsg(item)
                this.$router.push('/detail/' + item.id)
            },

            tabClick (item) {
                this.setSelectedItem(item)
                if(item === '预警事件') {
                    this.getEvents()
                }else {
                    this.getEvents([5, 6])
                }
            }
        }
    }

</script>
