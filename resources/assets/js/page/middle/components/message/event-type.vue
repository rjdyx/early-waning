<template>
    <div>{{scope.row.type == 1?'预警事件':'突发事件'}}</div>
</template>

<script>

    export default {
        name:'Sex',
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
