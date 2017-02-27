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

    export default{
        name:'Message',
        data () {
        	return {
                models: [
                    {
                        key: 'userManage',
                        tab: '用户管理',
                        url: '',
                        newComponent: null,
                        typeComponent: [{component: TypeManage, params: {title: '机构类别管理'}}],
                        theads: ['日期', '姓名', '地址'],
                        protos: ['date', 'name', 'address'],
                        widths: [120, 120, 120],
                        colComponent: []
                    }
                ]
        	}
        },
        methods: {

        }
    }

</script>
