/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div id="index">
    	<!-- 顶部栏目 -->
    	<my-header></my-header>

    	<!-- 左栏目 -->
    	<slider-bar
			:show="show"
            :navbars="navbars"
            @getSubNavbars="getSubNavbars"
    	></slider-bar>

    	<!-- 路由 -->
        <router-view></router-view>
    </div>
</template>

<style lang="sass" scoped>
    @import "../../sass/function";
	#index {
		height: 100%;
	}
</style>

<script>

    export default{
        name:'Index',
        data () {
        	return {
        		// 是否显示侧边栏
                show: true,
                // 侧边栏数据
                navbars: [
                    {
                        name:'信息管理',
                        role: 'plantation',
                        isEvent: false,
                        children: [
                            {
                                path: '/index/message/org',
                                name:'机构管理'
                            },
                            {
                                path: '/index/message/crew',
                                name:'人员管理'
                            },
                            {
                                path: '/index/message/condition',
                                name:'预警条件管理'
                            },
                            {
                                path: '/index/message/command',
                                name:'应急指挥管理'
                            }
                        ]
                    },
                    {
                        name:'反应系统',
                        role: 'plantation',
                        isEvent: false,
                        children: [
                            {
                                path: '/webapp/vegetable-harvest',
                                name:'预警事件管理'
                            },
                            {
                                path: '/webapp/vegetable-detection',
                                name:'突发事件管理'
                            }
                        ]
                    },
                    {
                        name:'分析系统',
                        role: 'beast',
                        isEvent: false,
                        children: [
                            {
                                path: '/webapp/beast',
                                name:'预警分析子系统'
                            },
                        ]
                    }
                ],
        	}
        },
        methods: {

        	getSubNavbars () {

        	}
        }
    }

</script>
