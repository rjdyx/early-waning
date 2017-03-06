/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2017/02/22
 * 
 */
<template>
    <div>
        <basic-model
            ref="basicModel"
            :models="models[type]"
        ></basic-model>
    </div>
</template>

<style lang="sass" scoped>
    @import "../../sass/function";

</style>

<script>

    import TypeManage from 'components/public/type-manage.vue'
    import Sex from 'components/public/sex.vue'
    import EventType from 'components/message/event-type.vue'

    export default{
        name:'Message',
        data () {
        	return {
                models:{
                    org:[
                        {
                            key: 'orgManage',
                            tab: '机构管理',
                            url: 'org',
                            searchPlaceholder: '请输入机构名称',
                            typeComponent: [{component: TypeManage, params: {title: '机构类别管理', type: 1}}],
                            theads: ['机构名称', '机构类型', '地址', '邮编', '固定电话', '手机', '传真', '备注'],
                            protos: ['name', 'org_level', 'address', 'zipcode', 'phone', 'cellphone', 'fax', 'meno'],
                            widths: [50, 50, 50, 50, 50, 50, 50, 50],
                            colComponent: {}
                        }
                    ],
                    crew:[
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
                    ],
                    condition:[
                        {
                            key: 'waningConditionManage',
                            tab: '预警条件管理',
                            url: 'waningcondition',
                            searchPlaceholder: '请输入预警条件名称',
                            typeComponent: [
                                {component: TypeManage, params: {title: '事件等级管理', type: 5}}, 
                                {component: TypeManage, params: {title: '事件类别管理', type: 6}}],
                            theads: ['事件类型', '条件编码', '条件描述'],
                            protos: ['type', 'code', 'description'],
                            widths: [50, 80, 100],
                            colComponent: {type: EventType}
                        }
                    ],
                    command:[
                        {
                            key: 'planManage',
                            tab: '预案管理',
                            url: 'plan',
                            searchPlaceholder: '请输入预案名称',
                            typeComponent: [{component: TypeManage, params: {title: '预案类型管理', type: 3}}],
                            theads: ['类型', '名称', '内容'],
                            protos: ['plan_type_name', 'name', 'content'],
                            widths: [50, 80, 100],
                            colComponent: {}
                        },
                        {
                            key: 'informationManage',
                            tab: '专题知识管理',
                            url: 'information',
                            searchPlaceholder: '请输入专题知识名称',
                            typeComponent: [{component: TypeManage, params: {title: '专题知识类型管理', type: 4}}],
                            theads: ['类型', '名称', '内容'],
                            protos: ['information_type_name', 'name', 'content'],
                            widths: [50, 80, 100],
                            colComponent: {}
                        }
                    ]
                }
        	}
        },
        computed: {
            type () {
                return this.$route.params.model
            }
        },
        beforeRouteUpdate (to, from, next) {
            this.$refs.basicModel.init(to.params.index)
            next()
        },
        methods: {

        }
    }

</script>
