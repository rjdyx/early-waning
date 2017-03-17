import status from './components/rbac/status.vue'
import lock from './components/rbac/lock.vue'

export default {
    'user':[
        {
            key: 'userManage',
            tab: '用户管理',
            url: 'user',
            searchPlaceholder: '请输入用户名',
            hideDeleteButton: true,
            typeComponent: [],
            theads: ['用户名', '邮箱', '状态', '注册时间'],
            protos: ['name', 'email', 'active', 'created_at'],
            widths: [50, 50, 50, 50],
            colComponent: {active: status, operation: lock}
        }
    ]
}