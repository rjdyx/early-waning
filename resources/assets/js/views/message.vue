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
                            colComponent: []
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
                            colComponent: []
                        }
                    ],

                } 
        	}
        },
        computed: {
            type () {
                return this.$route.params.model
            }
        },
        methods: {

        }
    }

</script>
