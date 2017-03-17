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
    },
    {
        name:'用户管理',
        role: 'rbac',
        isEvent: false,
        children: [
            {
                path: '/index/rbac/user/0',
                name:'用户管理'
            },
        ]
    }
]