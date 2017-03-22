<template>
    <pop-form
        :rows="rows" 
        :editForm="form" 
        :edit="edit"
        @addSuccess="$emit('addSuccess')"
    ></pop-form>
</template>

<script>

    import SelectRole from './select-role.vue'

    export default {
        name: 'PopUser',
        props: {
            form: {
                type: Object,
                default() {
                    return {}
                }
            },
            // 表示此模块是编辑模块还是新增模块的标志
            edit: {
                type: Boolean,
                default: false
            },
        },
        data () {
            return {
                rows: {
                    name: {
                        label: '用户名',
                        rules: ['required', 'max:20'],
                        value: '',
                        placeholder: '必填，长度不超过20'
                    },
                    email: {
                        label: '邮箱',
                        rules: ['required', 'max:50', 'email'],
                        value: '',
                        placeholder: '必填'
                    },
                    password: {
                        label: '密码',
                        rules: ['required', 'min:6'],
                        value: '',
                        type: 'password',
                        placeholder: '必填'
                    },
                    password_confirmation: {
                        label: '确认密码',
                        rules: ['required', 'confirmed:password', 'min:6'],
                        value: '',
                        type: 'password',
                        placeholder: '必填'
                    },
                    role: {
                        label: '角色',
                        component: SelectRole,
                        value: 0
                    }
                }
            }
        },
        mounted () {
            this.$popForm.setFormUrl('register')
        }
    }

</script>
