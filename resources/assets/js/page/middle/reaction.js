import TypeManage from 'components/public/type-manage.vue'
import Sex from 'components/public/sex.vue'
import Add from 'components/public/add.vue'
import EventHandle from 'components/public/event-handle.vue'
import EventDetail from 'components/public/event-detail.vue'

export default {
    'early-warning':[
        {
            key: 'undoWarningManage',
            tab: '待处理事件',
            url: 'event',
            urlParams: {status: 1},
            searchPlaceholder: '请输入待处理事件名称',
            operateComponent: [{component: Add, params: {status: 1}}],
            hideAddButton: true,
            typeComponent: [],
            theads: ['事件等级', '事件类别', '事件名称', '发生地区', '事件详情'],
            protos: ['event_level_name', 'event_sort_name', 'name', 'location', 'detail'],
            widths: [50, 50, 50, 50, 50],
            colComponent: {operation: EventHandle}
        },
        {
            key: 'doingWarningManage',
            tab: '正处理事件',
            url: 'event',
            urlParams: {status: 2},
            searchPlaceholder: '请输入正处理事件名称',
            operateComponent: [],
            hideAddButton: true,
            hideDeleteButton: true,
            typeComponent: [],
            theads: ['事件等级', '事件类别', '事件名称', '发生地区', '事件详情'],
            protos: ['event_level_name', 'event_sort_name', 'name', 'location', 'detail'],
            widths: [50, 50, 50, 50, 50],
            colComponent: {operation: EventDetail}
        }
    ],
    emergency:[
        {
            key: 'expertManage',
            tab: '专家管理',
            url: 'expert',
            searchPlaceholder: '请输入专家姓名',
            typeComponent: [{component: TypeManage, params: {title: '专家领域管理', type: 2}}],
            theads: ['姓名', '专家领域','所属机构','性别','学历', '职责', '职务', '住址', '邮编', '单位', '办公电话', '宅电', '手机', '邮箱', '备注'],
            protos: ['name', 'expert_area', 'org_name', 'sex', 'degree', 'duty', 'title', 'address', 'zipcode', 'company', 'officephone', 'homephone', 'cellphone', 'email', 'meno'],
            widths: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50],
            colComponent: {sex: Sex}
        },
        {
            key: 'emergencyCrewManage',
            tab: '应急人员管理',
            url: 'emergencycrew',
            searchPlaceholder: '请输入应急人员姓名',
            typeComponent: [{}],
            theads: ['姓名', '所属机构', '年龄', '性别', '职责', '职务', '固定电话', '手机', '邮箱', '备注'],
            protos: ['name', 'org_name', 'age', 'sex', 'duty', 'title', 'phone', 'cellphone', 'email', 'meno'],
            widths: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50],
            colComponent: {sex: Sex}
        }
    ]
}