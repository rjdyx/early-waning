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
        },
        {
            key: 'doneWarningManage',
            tab: '已完成事件',
            url: 'event',
            urlParams: {status: 3},
            searchPlaceholder: '请输入已完成事件名称',
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
            key: 'undoWarningManage',
            tab: '待处理事件',
            url: 'event',
            urlParams: {status: 4},
            searchPlaceholder: '请输入待处理事件名称',
            operateComponent: [{component: Add, params: {status: 4}}],
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
            urlParams: {status: 5},
            searchPlaceholder: '请输入正处理事件名称',
            operateComponent: [],
            hideAddButton: true,
            hideDeleteButton: true,
            typeComponent: [],
            theads: ['事件等级', '事件类别', '事件名称', '发生地区', '事件详情'],
            protos: ['event_level_name', 'event_sort_name', 'name', 'location', 'detail'],
            widths: [50, 50, 50, 50, 50],
            colComponent: {operation: EventDetail}
        },
        {
            key: 'doneWarningManage',
            tab: '已完成事件',
            url: 'event',
            urlParams: {status: 6},
            searchPlaceholder: '请输入已完成事件名称',
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
    meeting:[
        {
            key: 'undoMeetingManage',
            tab: '待处理会议',
            url: 'meeting',
            urlParams: {status: 1},
            searchPlaceholder: '请输入待处理会议名称',
            operateComponent: [{component: Add, params: {status: 1}}],
            hideAddButton: true,
            typeComponent: [],
            theads: ['事件等级', '事件类别', '事件名称', '发生地区', '事件详情'],
            protos: ['event_level_name', 'event_sort_name', 'name', 'location', 'detail'],
            widths: [50, 50, 50, 50, 50],
            colComponent: {operation: EventHandle}
        },
        {
            key: 'doingMeetingManage',
            tab: '正处理事件',
            url: 'meeting',
            urlParams: {status: 2},
            searchPlaceholder: '请输入正处理会议名称',
            operateComponent: [],
            hideAddButton: true,
            hideDeleteButton: true,
            typeComponent: [],
            theads: ['事件等级', '事件类别', '事件名称', '发生地区', '事件详情'],
            protos: ['event_level_name', 'event_sort_name', 'name', 'location', 'detail'],
            widths: [50, 50, 50, 50, 50],
            colComponent: {operation: EventDetail}
        },
        {
            key: 'doneMeetingManage',
            tab: '已完成事件',
            url: 'meeting',
            urlParams: {status: 3},
            searchPlaceholder: '请输入已完成会议名称',
            operateComponent: [],
            hideAddButton: true,
            hideDeleteButton: true,
            typeComponent: [],
            theads: ['事件等级', '事件类别', '事件名称', '发生地区', '事件详情'],
            protos: ['event_level_name', 'event_sort_name', 'name', 'location', 'detail'],
            widths: [50, 50, 50, 50, 50],
            colComponent: {operation: EventDetail}
        }
    ]
}