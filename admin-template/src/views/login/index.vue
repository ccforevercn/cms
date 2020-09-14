<template>
  <div class="login-container">
    <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login-form" auto-complete="on" label-position="left">
      <div class="title-container">
        <h3 class="title" v-text="loginName" />
      </div>
      <el-form-item prop="username">
        <span class="svg-container">
          <svg-icon icon-class="user" />
        </span>
        <el-input
          ref="username"
          v-model="loginForm.username"
          placeholder="请输入账号"
          name="username"
          type="text"
          tabindex="1"
          auto-complete="on"
        />
      </el-form-item>

      <el-form-item prop="password">
        <span class="svg-container">
          <svg-icon icon-class="password" />
        </span>
        <el-input
          :key="passwordType"
          ref="password"
          v-model="loginForm.password"
          :type="passwordType"
          placeholder="请输入密码"
          name="password"
          tabindex="2"
          auto-complete="on"
          @keyup.enter.native="handleLogin"
        />
        <span class="show-pwd" @click="showPwd">
          <svg-icon :icon-class="passwordType === 'password' ? 'eye' : 'eye-open'" />
        </span>
      </el-form-item>
      <el-form-item prop="captcha">
        <span class="svg-container">
          <i class="el-icon-s-comment" />
        </span>
        <el-input
          ref="captcha"
          v-model="loginForm.captcha"
          class="captcha"
          placeholder="请输入验证码"
          name="captcha"
          type="text"
          tabindex="3"
          auto-complete="on"
          @keyup.enter.native="handleLogin"
        />
        <el-image class="captcha-image" :src="captchaBase64" @click.native.prevent="getCaptcha" />
      </el-form-item>
      <el-button :loading="loading" type="primary" class="login-form-login-submit" @click.native.prevent="handleLogin">登陆</el-button>
    </el-form>
  </div>
</template>

<script>
import { captcha } from '@/api/public'

export default {
  name: 'Login',
  data() {
    const validateUsername = (rule, value, callback) => {
      if (value.length > 16 || value.length < 6) {
        callback(new Error('账号不能小于6位，不能大于16位'))
      } else {
        callback()
      }
    }
    const validatePassword = (rule, value, callback) => {
      if (value.length > 18 || value.length < 8) {
        callback(new Error('密码不能小于8位，不能大于18位'))
      } else {
        callback()
      }
    }
    const validateCaptcha = (rule, value, callback) => {
      if (value.length < 4) {
        callback(new Error('请输入验证码'))
      } else {
        callback()
      }
    }
    return {
      loginForm: {
        username: 'ccforever',
        password: '68888886',
        captcha: '',
        key: ''
      },
      loginRules: {
        username: [{ required: true, trigger: 'blur', validator: validateUsername }],
        password: [{ required: true, trigger: 'blur', validator: validatePassword }],
        captcha: [{ required: true, trigger: 'blur', validator: validateCaptcha }]
      },
      captchaBase64: '',
      loading: false,
      passwordType: 'password',
      redirect: undefined,
      loginName: '登陆'
    }
  },
  watch: {
    $route: {
      handler: function(route) {
        this.redirect = route.query && route.query.redirect
      },
      immediate: true
    }
  },
  mounted() {
    // 获取验证码
    this.getCaptcha()
  },
  methods: {
    getCaptcha() {
      var that = this
      captcha().then(res => {
        that.loginForm.key = res.data.key
        that.captchaBase64 = res.data.url
      })
    },
    showPwd() {
      if (this.passwordType === 'password') {
        this.passwordType = ''
      } else {
        this.passwordType = 'password'
      }
      this.$nextTick(() => {
        this.$refs.password.focus()
      })
    },
    handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid) {
          this.loading = true
          this.$store.dispatch('user/login', this.loginForm).then(() => {
            this.$router.push({ path: '/' })
            this.loading = false
          }).catch(() => {
            this.loading = false
          })
        } else {
          console.log('error submit!!')
          return false
        }
      })
    }
  }
}
</script>

<style lang="scss">
$bg:#283443;
$light_gray:#fff;
$cursor: #fff;

@supports (-webkit-mask: none) and (not (cater-color: $cursor)) {
  .login-container .el-input input {
    color: $cursor;
  }
}

/* reset element-ui css */
.login-container {
  .el-input {
    display: inline-block;
    height: 47px;
    width: 85%;
    input {
      background: transparent;
      border: 0px;
      -webkit-appearance: none;
      border-radius: 0px;
      padding: 12px 5px 12px 15px;
      color: $light_gray;
      height: 50px;
      caret-color: $cursor;

      &:-webkit-autofill {
        box-shadow: 0 0 0px 1000px $bg inset !important;
        -webkit-text-fill-color: $cursor !important;
      }
    }
  }
  .captcha{
    display: inline-block;
    height: 47px;
    width: 60%;
    input {
      background: transparent;
      border: 0px;
      -webkit-appearance: none;
      border-radius: 0px;
      padding: 12px 5px 12px 15px;
      color: $light_gray;
      height: 47px;
      caret-color: $cursor;

      &:-webkit-autofill {
        box-shadow: 0 0 0px 1000px $bg inset !important;
        -webkit-text-fill-color: $cursor !important;
      }
    }
  }
  .captcha-image{
    display: inline-block;
    width: 30%;
    height: 42px;
    overflow:unset;
    img{
      border-radius: 5px;
    }
  }

  .el-form-item {
    border: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    color: #454545;
  }
}
</style>

<style lang="scss" scoped>
$bg:#9966FF;
$bg_top:#9966FF;
$bg_bottom:#6666FF;
$dark_gray:#7d21bf;
$light_gray:#00000066;
$form_bg:#9966FF;
$bg_form_top:#9966FF;
$bg_form_bottom:#6666FF;

.login-container {
  min-height: 100%;
  width: 100%;
  background: $bg;
  background: -moz-linear-gradient(top, $bg_top 0%, $bg_bottom 100%);
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, $bg_top), color-stop(100%, $bg_bottom));
  background: -webkit-linear-gradient(top, $bg_top 0%, $bg_bottom 100%);
  background: -o-linear-gradient(top, $bg_top 0%, $bg_bottom 100%);
  background: -ms-linear-gradient(top, $bg_top 0%, $bg_bottom 100%);
  background: linear-gradient(to bottom, $bg_top 0%, $bg_bottom 100%);

  overflow: hidden;

  .login-form {
      position: relative;
      width: 500px;
      height: 600px;
      max-width: 100%;
      padding: 20px 35px 0;
      margin: 0 auto;
      overflow: hidden;
      background: $form_bg;
      background: -moz-linear-gradient(top, $bg_form_top 0%, $bg_form_bottom 100%);
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, $bg_form_top), color-stop(100%, $bg_form_bottom));
      background: -webkit-linear-gradient(top, $bg_form_top 0%, $bg_form_bottom 100%);
      background: -o-linear-gradient(top, $bg_form_top 0%, $bg_form_bottom 100%);
      background: -ms-linear-gradient(top, $bg_form_top 0%, $bg_form_bottom 100%);
      background: linear-gradient(to bottom, $bg_form_top 0%, $bg_form_bottom 100%);
      margin-top: 12%;
      border-radius: 20px;
      .login-form-login-submit{
        width: 100%;
        margin: 30px 0;
      }
  }

  .tips {
    font-size: 14px;
    color: #fff;
    margin-bottom: 10px;

    span {
      &:first-of-type {
        margin-right: 16px;
      }
    }
  }

  .svg-container {
    padding: 6px 5px 6px 15px;
    color: $dark_gray;
    vertical-align: middle;
    width: 30px;
    display: inline-block;
  }

  .title-container {
    position: relative;
    .title {
      font-size: 40px;
      color: $light_gray;
      margin: 40px auto 80px auto;
      text-align: center;
      font-weight: bold;
    }
  }

  .show-pwd {
    position: absolute;
    right: 10px;
    top: 7px;
    font-size: 16px;
    color: $dark_gray;
    cursor: pointer;
    user-select: none;
  }
}
</style>
