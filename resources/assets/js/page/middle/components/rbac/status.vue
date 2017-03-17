<template>
    <div>{{scope.row.active == 0?'可用':'禁止'}}</div>
</template>

<script>

    export default {
        name:'Status',
        props:{
            scope: {
                type: Object,
                required: true,
                default () {
                    return {}
                }
            }
        }

    }
</script>
