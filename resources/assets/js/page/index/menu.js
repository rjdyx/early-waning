/**
 * 左菜单栏数据
 */
export default [
	{
        name:'信息管理',
        role: 'message',
        children: [
            {
                path: '/index/message/org/0',
                name:'机构管理'
            },
            {
                path: '/index/message/crew/0',
                name:'人员管理'
            },
            {
                path: '/index/message/condition/0',
                name:'预警条件管理'
            },
            {
                path: '/index/message/command/0',
                name:'应急指挥管理'
            }
        ]
    },
    {
        name:'反应系统',
        role: 'reaction',
        children: [
            {
                path: '/index/reaction/early-warning/0',
                name:'预警事件管理'
            },
            {
                path: '/index/reaction/emergency/0',
                name:'突发事件管理'
            },
            {
                path: '/index/reaction/meeting/0',
                name:'会议管理'
            }
        ]
    },
    {
        name:'分析系统',
        role: 'analyse',
        isEvent: false,
        children: [
            {
                path: '/index/model',
                name:'模型构建'
            },
            {
                path: '/index/analyse',
                name:'预警分析'
            }
        ]
    },
    {
        name:'系统管理',
        role: 'rbac',
        isEvent: false,
        children: [
            {
                path: '/index/rbac/user/0',
                name:'用户管理'
            },
            {
                path: '/index/rbac/system/0',
                name:'系统配置'
            },
        ]
    }
]