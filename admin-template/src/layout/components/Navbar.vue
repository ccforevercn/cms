<template>
  <div class="navbar">
    <hamburger :is-active="sidebar.opened" class="hamburger-container" @toggleClick="toggleSideBar" />

    <breadcrumb class="breadcrumb-container" />

    <div class="right-menu">
      <el-dropdown trigger="click" class="chat-list" v-if="speak.length > 0">
        <el-badge value="new" class="item">
          <el-button size="small">用户留言</el-button>
        </el-badge>
        <el-dropdown-menu slot="dropdown">
          <template v-for="(item, index) in speak">
            <el-dropdown-item :key="index" @click.native="toChat(item)">{{ item }}</el-dropdown-item>
          </template>
        </el-dropdown-menu>
      </el-dropdown>
      <el-dropdown class="avatar-container" trigger="click">
        <div class="avatar-wrapper">
          <el-button type="success" plain size="small">菜单</el-button>
        </div>
        <el-dropdown-menu slot="dropdown" class="user-dropdown">
          <router-link to="/">
            <el-dropdown-item>后台首页</el-dropdown-item>
          </router-link>
           <el-dropdown-item divided @click.native="chat">
            <span style="display:block;">留言消息</span>
          </el-dropdown-item>
          <el-dropdown-item divided @click.native="logout">
            <span style="display:block;">退出</span>
          </el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Breadcrumb from '@/components/Breadcrumb'
import Hamburger from '@/components/Hamburger'
import {chatsSee} from '@/api/chats'

export default {
  components: {
    Breadcrumb,
    Hamburger
  },
  computed: {
    ...mapGetters([
      'sidebar',
      'speak'
    ])
  },
  methods: {
    toChat(item) {
      var that = this
      chatsSee({user: item}).then(res=>{
          that.$store.dispatch('chat/shut', item)
          that.$store.dispatch('chat/user', item)
      }).catch(err=>{
          that.$message({ type: 'error', message: err || '获取失败' })
      })   
    },
    chat() {
      this.$store.dispatch('chat/chat')
    },
    toggleSideBar() {
      this.$store.dispatch('app/toggleSideBar')
    },
    async logout() {
      await this.$store.dispatch('user/logout')
      this.$router.push(`/login?redirect=${this.$route.fullPath}`)
    }
  }
}
</script>

<style lang="scss" scoped>
.navbar {
  height: 50px;
  overflow: hidden;
  position: relative;
  background: #fff;
  box-shadow: 0 1px 4px rgba(0,21,41,.08);

  .hamburger-container {
    line-height: 48px;
    height: 100%;
    float: left;
    cursor: pointer;
    transition: background .3s;
    -webkit-tap-highlight-color:transparent;

    &:hover {
      background: rgba(0, 0, 0, .025)
    }
  }

  .breadcrumb-container {
    float: left;
  }

  .right-menu {
    float: right;
    height: 100%;
    line-height: 50px;

    &:focus {
      outline: none;
    }
    .chat-list{
      margin-right: 20px;
    }

    .right-menu-item {
      display: inline-block;
      padding: 0 8px;
      height: 100%;
      font-size: 18px;
      color: #5a5e66;
      vertical-align: text-bottom;

      &.hover-effect {
        cursor: pointer;
        transition: background .3s;

        &:hover {
          background: rgba(0, 0, 0, .025)
        }
      }      
    }

    .avatar-container {
      margin-right: 30px;

      .avatar-wrapper {
        margin-top: 5px;
        position: relative;

        .user-avatar {
          cursor: pointer;
          width: 40px;
          height: 40px;
          border-radius: 10px;
        }

        .el-icon-caret-bottom {
          cursor: pointer;
          position: absolute;
          right: -20px;
          top: 25px;
          font-size: 12px;
        }
      }
    }
  }
}
</style>
