<template>
  <div class="chat" v-show="chat === true">
      <div class="top">
          <div class="content">用户留言列表 <span class="close" @click="close"><i class="el-icon-close"></i></span> </div>
      </div>
      <div class="content" ref="chat">
          <div class="user-list" v-show="userListStatus === true">
            <div class="item" v-for="item in users" :key="item.user" @click="chatCurrent(item)">
                <span v-text="'用户' + item.id" :key="item.id"></span>
                <el-divider content-position="right" :key="item.id">{{ item.time | timeFilter}} </el-divider>
            </div>
            <div class="bottom-loading" v-show="userWhereload === true && userWhereStatus == false"><i class="el-icon-loading"></i>加载中...</div>
            <div class="bottom-loading" v-show="userWhereStatus == true">加载完成</div>
          </div>
          <div class="chat-list" v-show="chatListStatus === true">
              <div class="user"><el-page-header @back="toUserList" content="留言记录"></el-page-header></div>
              <div :class="userCheck ? 'list' : 'list-total'" ref="chat_list">
                  <div class="item" v-for="item in chats" :key="item.id">
                    <span v-text="(item.speak.length === 32 ? '用户' : '管理员') + '：' +item.content" :key="item.id"></span>
                    <el-divider content-position="right" :key="item.id">{{ item.add_time | timeFilter}} </el-divider>
                </div>
              </div>
              <div class="speak" v-show="userCheck === true">

                  <el-form class="form">
                    <el-input type="textarea" class="speak-content" v-model="speakContent" :rows="rows" placeholder="聊天内容"></el-input>
                    <el-button type="primary" class="bottom" @click="seed">发送</el-button>
                </el-form>
              </div>
          </div>
      </div>
  </div>
</template>
<script>

import { mapGetters } from 'vuex'
import store from '@/store'
import { GetUsers, GetChats } from '@/api/chats'
import { secondToTime } from '@/utils/time'
import { connect, formatDataSend, check } from '@/utils/ws'
import { getScrollBotom, scrollBotom, getScrollTop } from '@/utils/scroll'

export default {
  name: 'Chat',
  filters: {
    timeFilter(second) {
      return secondToTime(second)
    }
  },
  computed: {
    ...mapGetters([
      'chat',
      'user',
      'admin'
    ])
  },
  watch: {
      chat(value) {
        if(value == true){
            this.$refs.chat.addEventListener('scroll', this.userScrollBottom)
        }
        this.getUsers()
      },
      user(value) {
          if(value.length > 0){
            this.userCheck = true
            this.chatWhere.user = value
            this.getChats()
          }          
      }
  },
  data() {
    return {
        users: [], // 用户列表
        userWhere: { 'customer' : '', 'page' : 1, 'limit' : 10 }, // 用户列表where
        userWhereload: false, // 是否加载用户中 true 是  false 否
        userWhereStatus: false, // 是否加载完所有用户 true 是 false 否
        userListStatus: false, // 用户列表是否展示  true 是 false 否
        chats: [], // 聊天列表
        chatWhere: { 'customer' : '', 'user' : '', 'page' : 1, 'limit' : 8 }, // 聊天列表where
        chatWhereload: false, // 是否加载聊天记录中 true 是  false 否
        chatWhereStatus: false, // 是否加载完聊天记录 true 是 false 否
        chatListStatus: false, // 聊天列表是否展示  true 是 false 否
        speakContent:'', // 管理员回复内容
        rows: 6, // 管理员回复内容文本框大小
        socket: null, // 链接的socket
        userCheck: false // 当前用户是否在线 false 下线 true 在线(展示管理员回复文本框)
    }
  },
  created() {
      this.userWhere.customer = this.admin.username
      this.chatWhere.customer = this.admin.username
      this.getUsers()
      this.socketConnect()
      if(this.chat === true){
        this.$nextTick(()=>{
            this.$refs.chat.addEventListener('scroll', this.userScrollBottom)
        })
      }
  },
  methods: {
      toUserList() {
          // 返回用户列表
        this.userListStatus = true
        this.chatListStatus = false
      },
      userScrollBottom() {
        // 下拉加载用户列表
        let scrollBotom
        var that = this
        scrollBotom = getScrollBotom(that.$refs.chat)
        if(scrollBotom < 10){
            // 加载用户列表
            that.getUsers()
        }
      },
        socketConnect() {
            // 启动socket
            connect(this)
        },
        socketMessages(user) {
            // 用户发送来消息是调用
            this.chatWhereload = false
            this.chatWhereStatus = false
            this.chatWhere.page = 1
            this.chats = []
            this.chatWhere.user = user
            this.getChats()
        },
        seed() {
            // 给用户发送留言
            var that = this
            if(this.speakContent.length > 0){
                formatDataSend('chats_admin', {content: that.speakContent, user: that.chatWhere.user})
                that.speakContent = ''
            }else{
                that.$message({ type: 'error', message: '请输入回复内容' })
            }
        },
        chatCurrent(item) {
            // 获取当前用户记录和是否在线
            var that = this
            that.chatWhereload = false
            that.chatWhereStatus = false
            that.chatWhere.page = 1
            that.chats = []
            that.chatWhere.user = item.user
            check(item.user, function(data){
                if(data.data.status === true){
                    // 用户在线
                    that.userCheck = true
                }else{
                    // 用户下线
                    that.userCheck = false
                }
                that.getChats()
            })
        },
        close() {
            // 关闭留言窗口
            store.dispatch('chat/chat')
        },
        chatScrollBottom() {
            // 上拉加载留言列表
            var that = this
            let scrollTop
            scrollTop  =getScrollTop(that.$refs.chat_list)
            if(scrollTop < 10){
                that.getChats()
            }
        },
        getChats() {
            // 获取留言客服和用户对话列表
            var that = this
            if(that.chatWhereload || that.chatWhereStatus) return
            that.chatWhereload = true
            GetChats(that.chatWhere).then(res=>{
                let length 
                length = res.data.list.length
                for(let index in res.data.list){
                    that.chats.unshift(res.data.list[index])
                }
                that.chatWhereStatus = length < that.chatWhere.limit
                that.userListStatus = false
                that.chatListStatus = true
                that.$nextTick(()=>{
                    that.$refs.chat_list.addEventListener('scroll', that.chatScrollBottom)
                    that.chatWhereload = false
                    if(that.chatWhere.page === 1){
                        scrollBotom(that.$refs.chat_list)
                    }
                    that.chatWhere.page++
                })
            }).catch(err=>{
                that.$message({ type: 'error', message: err || '获取失败' })
            })
        },
        getUsers() {
            // 获取留言用户列表
            var that = this
            if(that.userWhereload || that.userWhereStatus) return
            that.userWhereload = true
            GetUsers(that.userWhere).then(res=>{
                let length 
                length = res.data.list.length
                that.users = that.users.concat(res.data.list)
                that.userWhereStatus = length < that.userWhere.limit
                that.userListStatus = true
                that.chatListStatus = false
                that.userWhereload = false
                that.userWhere.page++
            }).catch(err=>{
                that.$message({ type: 'error', message: err || '获取失败' })
            })
        },
  }
}
</script>

<style lang="scss" scoped>
$chatBorderColor:#00000030;
$chatBoxShadow:#00000030;
$bg:#9966FF;
$bg_top:#9966FF;
$bg_bottom:#6666FF;
.el-divider,.el-divider__text{
    background-color: $bg
}
.chat {
    height: 600px;
    width: 320px;
    position: absolute;
    bottom: 0;
    right: 0;
    border: 1px solid $chatBorderColor;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    box-shadow: 1px 1px 50px $chatBoxShadow;
    background: $bg;
    background: -moz-linear-gradient(top, $bg_top 0%, $bg_bottom 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, $bg_top), color-stop(100%, $bg_bottom));
    background: -webkit-linear-gradient(top, $bg_top 0%, $bg_bottom 100%);
    background: -o-linear-gradient(top, $bg_top 0%, $bg_bottom 100%);
    background: -ms-linear-gradient(top, $bg_top 0%, $bg_bottom 100%);
    background: linear-gradient(to bottom, $bg_top 0%, $bg_bottom 100%);
    .top{
        height: 70px;
        text-align: center;
        border-bottom: 1px solid #6666CC;
        .content{
            height: 70px;
            line-height: 70px;
            .close{
                position: absolute;
                top: 6px;
                right: 20px;
                font-size: 20px;
                cursor: pointer;
            }
        }
    }
    .content::-webkit-scrollbar {
        display: none;
    }
    .content{
        scrollbar-width: none;
        -ms-overflow-style: none;
        overflow-x: hidden;
        overflow-y: auto;
        padding: 6px 10px 0 10px;
        height: 520px;
        .user-list{    
            height: 100%;
            .bottom-loading{
                text-align: center;
            }
            .item{
                cursor: pointer;
            }
        }
        .chat-list{            
            height: 100%;
            .user{
                margin-bottom: 10px;
                text-align: right;
            }
            .list-total{
                height: 480px;
                scrollbar-width: none;
                -ms-overflow-style: none;
                overflow-x: hidden;
                overflow-y: auto;
            }
            .list-total::-webkit-scrollbar {
                display: none;
            }
            .list{
                height: 240px;
                scrollbar-width: none;
                -ms-overflow-style: none;
                overflow-x: hidden;
                overflow-y: auto;
            }
            .list::-webkit-scrollbar {
                display: none;
            }
            .speak{
                height: 200px;
                width: 100%;
                .form{
                    width: 100%;
                    .speak-content{

                        padding: 10px 10px;
                    }
                    .bottom{
                        padding: 10px 10px;
                        width: 100%;
                    }
                }
            }
        }
    }
}
</style>
