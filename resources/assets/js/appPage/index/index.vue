/**
 * 
 * 最顶层组件
 * @description 最顶层的组件，但不包含登录、404页面这些组件
 * @author 苏锐佳
 * @date 2016/12/14
 * 
 */
<template>

    <div>
        <group>
            <cell title="title" value="value"></cell>
        </group>
    </div>
</template>
<style lang="sass" scoped>

</style>
<script>

    import { Group, Cell } from 'vux'

    export default{
        name:'Index',
        components: {
            Group,
            Cell
        }
    }

</script>
