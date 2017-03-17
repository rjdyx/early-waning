/**
 * 
 * 登录组件
 * @description 
 * @author 苏锐佳
 * @date 2016/12/14
 * 
 */
<template>
    <div class="content">
        <form @submit.prevent="login">
            <ul>
                <li>
                    <div v-if="isError" class="err-tip">用户名或密码错误</div>
                    <input 
                        v-focus 
                        v-model="user.login" 
                        v-validate.initial="user.login" 
                        data-vv-rules="required" 
                        data-vv-as="用户名" 
                        :placeholder="userNamePlaceholder" 
                        :class="{red: isNameError}" 
                        name="login" type="text">
                </li>
                <li>
                    <input 
                        v-model="user.password" 
                        v-validate.initial="user.password" 
                        data-vv-rules="required" 
                        data-vv-as="密码" 
                        :placeholder="passwordPlaceholder" 
                        :class="{red: isPasswordError}" 
                        name="password" type="password">
                </li>
            </ul>
            <div class="login-btn">
                <a>
                    <button type="submit" :disabled="isLogin">{{loginBtn}}</button>
                </a>
            </div>
        </form>
        
    </div>
</template>

<style lang="sass" scoped>

    @import "../../sass/function";

    .content {
        
        height: 100%;
        /*background: #009acb;*/

        form {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            height: pxToRem(255);
            padding-bottom: pxToRem(47);
            /*background: #009acb;*/
        }

        .err-tip {
            position: absolute;
            top: pxToRem(-31);
            color: red;
        }

        ul {

            width: pxToRem(300);
            margin: 0 auto;

            li {
                position: relative;
                width: pxToRem(300);
                padding-bottom: pxToRem(20);

                input {
                    width: pxToRem(300);
                    height: pxToRem(55);
                    padding-left: pxToRem(17);
                    border: 0;
                }

                span {
                    position: absolute;
                    right: pxToRem(10);
                    top: 0;
                    bottom: 0;
                    margin: auto;
                    display: inline-block;
                    width: pxToRem(25);
                    height: pxToRem(25);
                    background-size: 100%;
                    background-repeat: no-repeat;

                }

                &:nth-child(1) span {
                    background-image: url(/public/user.png);
                }

                &:nth-child(2) span {
                    background-image: url(/public/password.png);
                }
            }
        }

        .login-btn {

            width: pxToRem(300);
            margin: 0 auto;

            button {
                width: pxToRem(300);
                height: pxToRem(55);
                background: #009acb;
                color: white;
                border: 1px solid white;
                font-size: pxToRem(22);
            }

            a:active {
                button {
                   background: #048ab5;
                }
            }
        }
    }
    
      
    /*placeholder*/
    ::-webkit-input-placeholder {
        /* WebKit browsers */
        color: #d6d6d7 !important; 
    }

    :-ms-input-placeholder {
        /* Internet Explorer 10+ */
        color: #d6d6d7 !important; 
    }

    /*placeholder*/
    input[class=red]::-webkit-input-placeholder {
        /* WebKit browsers */
        color: #fd6e64 !important; 
    }

    input[class=red]:-ms-input-placeholder {
        /* Internet Explorer 10+ */
        color: #fd6e64 !important; 
    }
</style>

<script>

    import {mapMutations} from 'vuex'

    export default{
        name: 'Login',
        data(){
            return{
                self: this,
                user: {
                    login: '',
                    password: ''
                },
                // 用户名表单验证出错的标志
                isNameError: false,
                // 密码表单验证出错的标志
                isPasswordError: false,
                // 后端用户名或密码不匹配的标志
                isError: false,
                // 登录按钮的文本
                loginBtn: '登录',
                // 登录按钮是否可用的标志，false表示可用
                isLogin: false
            }
        },
        computed: {
            userNamePlaceholder () {
                if(this.verrors.has('login')) {
                    this.isNameError = true;
                    return this.verrors.first('login');
                }
                return '用户名/邮箱/电话';
            },
            passwordPlaceholder () {
                if(this.verrors.has('password')) {
                    this.isPasswordError = true;
                    return this.verrors.first('password');
                }
                return '密码';
            }
        },
        mounted () {
            if(this.$route.params.code == '401') {
                axios.get('/token').then((response)=>{
                    window.role = response.data;
                    Laravel.csrfToken = response.data.token;
                }).catch(function (error) {
                    if(error.status != 200) {
                        this.loginBtn = '登录'
                        this.isLogin = false
                        alert('token获取失败');
                    }
                });
            }
        },
        methods: {

            ...mapMutations([
                'setUserInfo'
            ]),

            /**
             * 登录
             */
            login () {
                this.showLogoFn();
                // 验证表单
                this.$validator.validateAll();
                // 如果表单报错则不提交
                if(this.verrors.any()) {
                    return false;
                }else {
                    this.loginBtn = '登录中...'
                    this.isLogin = true;
                    axios.post('/login', this.user).then((response)=>{
                        if(response.data == '用户名或密码错误'){
                            this.isError = true
                            this.loginBtn = '登录'
                            this.isLogin = false
                        }else {
                            // sessionStorage.setItem('user', response.data)
                            // this.setUserInfo(response.data)
                            window.role = response.data;
                            let isPlantation = response.data.role1.some(function(item, index) {
                                return item === 'plantation'
                            })

                            if(isPlantation) {
                                this.$router.push('/webapp')
                                return true
                            }else {
                                this.$router.push('/webapp/beast')
                            }
                            
                        }
                    }).catch(function (error) {
                        if(error.status != 200) {
                            this.loginBtn = '登录'
                            this.isLogin = false
                            this.$alert('连接出错，请重新登录', 'e')
                        }
                    });
                }
            }
        }
    }
</script>
