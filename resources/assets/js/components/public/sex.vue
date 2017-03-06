<template>
    <div>{{scope.row.sex == 1?'男':'女'}}</div>
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
