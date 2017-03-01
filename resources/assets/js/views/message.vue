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
            :models="models"
        ></basic-model>
    </div>
</template>

<style lang="sass" scoped>
    @import "../../sass/function";

</style>

<script>

    import TypeManage from 'components/public/type-manage.vue'
    import PopOrg from 'components/message/pop-org.vue'

    export default{
        name:'Message',
        data () {
        	return {
                models: [
                    {
                        key: 'orgManage',
                        tab: '机构管理',
                        url: 'org',
                        searchPlaceholder: '请输入机构名称',
                        newComponent: PopOrg,
                        typeComponent: [{component: TypeManage, params: {title: '机构类别管理', type: 1}}],
                        theads: ['机构名称', '机构类型', '地址', '邮编', '固定电话', '手机', '传真', '备注'],
                        protos: ['name', 'org_level', 'address', 'zipcode', 'phone', 'cellphone', 'fax', 'meno'],
                        widths: [50, 50, 50, 50, 50, 50, 50, 50],
                        colComponent: []
                    }
                ]
        	}
        },
        methods: {

        }
    }

</script>
