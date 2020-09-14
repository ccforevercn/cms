<template>
  <div class="app-container">
    <el-row :gutter="24"><el-col class="insert-button"><el-button type="success" plain size="small" @click="fetchData">刷新列表</el-button></el-col></el-row>
    <el-table v-loading="listLoading" :data="list" element-loading-text="Loading" border fit highlight-current-row>
      <template slot="empty">暂无留言</template>
      <el-table-column align="center" label="客服信息">
        <template slot-scope="scope">{{ scope.row.admin_name }}/{{ scope.row.customer }}/{{ scope.row.admin_id }}</template>
      </el-table-column>
      <el-table-column label="留言用户(数量)">
        <template slot-scope="scope"><span>{{ scope.row.user_count }}</span></template>
      </el-table-column>
      <el-table-column align="center" label="操作" width="120">
        <template slot-scope="scope"><el-button type="primary" icon="el-icon-s-custom" @click="user(scope.$index)" /></template>
      </el-table-column>
    </el-table>
    <el-row :gutter="24">
      <el-col :span="24" class="page-class">
        <el-pagination
          background
          :page-size="where.limit"
          :pager-count="5"
          layout="prev, pager, next"
          :total="count"
          @size-change="pageSizeChange"
          @current-change="pageCurrentChange"
          @prev-click="pagePrevClick"
          @next-click="pageNextClick"
        />
      </el-col>
    </el-row>
    <el-dialog :title="userDialog.title" :visible.sync="userDialog.visible" width="90%" center>
      <el-table :data="userDialog.list" border fit highlight-current-row>
        <template slot="empty">暂无留言</template>
        <el-table-column align="center" label="用户昵称">
          <template slot-scope="scope">用户{{ scope.row.id }}</template>
        </el-table-column>
        <el-table-column label="留言条数(数量)">
          <template slot-scope="scope"><span>{{ scope.row.content_count }}</span></template>
        </el-table-column>
        <el-table-column label="留言时间">
          <template slot-scope="scope"><span>{{ scope.row.time | timeFilter }}</span></template>
        </el-table-column>
        <el-table-column align="center" label="操作" width="120">
          <template slot-scope="scope"><el-button type="primary" icon="el-icon-s-custom" @click="chat(scope.$index)" /></template>
        </el-table-column>
      </el-table>
      <el-row :gutter="24">
        <el-col :span="24" class="page-class">
          <el-pagination
            background
            :page-size="userDialog.where.limit"
            :pager-count="5"
            :current-page="userDialog.where.page"
            layout="prev, pager, next"
            :total="userDialog.count"
            @size-change="pageSizeChangeUser"
            @current-change="pageCurrentChangeUser"
            @prev-click="pagePrevClickUser"
            @next-click="pageNextClickUser"
          />
        </el-col>
      </el-row>
    </el-dialog>
    <el-dialog :title="chatDialog.title" :visible.sync="chatDialog.visible" width="80%" center>
      <el-table :data="chatDialog.list" border fit highlight-current-row>
        <template slot="empty">暂无留言</template>
        <el-table-column label="编号">
          <template slot-scope="scope"><span>{{ scope.row.id }}</span></template>
        </el-table-column>
        <el-table-column align="center" label="用户昵称">
          <template slot-scope="scope">{{ scope.row.user }}</template>
        </el-table-column>
        <el-table-column label="发言人">
          <template slot-scope="scope"><span>{{ scope.row.speak }}</span></template>
        </el-table-column>
        <el-table-column label="内容">
          <template slot-scope="scope"><span>{{ scope.row.content }}</span></template>
        </el-table-column>
        <el-table-column label="时间">
          <template slot-scope="scope"><span>{{ scope.row.add_time | timeFilter }}</span></template>
        </el-table-column>
      </el-table>
      <el-row :gutter="24">
        <el-col :span="24" class="page-class">
          <el-pagination
            background
            :page-size="chatDialog.where.limit"
            :current-page="chatDialog.where.page"
            :pager-count="5"
            layout="prev, pager, next"
            :total="chatDialog.count"
            @size-change="pageSizeChangeChat"
            @current-change="pageCurrentChangeChat"
            @prev-click="pagePrevClickChat"
            @next-click="pageNextClickChat"
          />
        </el-col>
      </el-row>
    </el-dialog>
  </div>

</template>

<script>
import { GetList, GetUsers, GetChats } from '@/api/chats'
import { secondToTime } from '@/utils/time'

export default {
  filters: {
    timeFilter(second) {
      return secondToTime(second)
    }
  },
  data() {
    return {
      where: { 'page': 1, 'limit': 6 },
      list: null,
      count: 0,
      listLoading: true,
      userDialog: {
        title: '用户留言列表',
        visible: false,
        list: null,
        count: 0,
        user: null,
        where: { 'customer': '', 'page': 1, 'limit': 6 }
      },
      chatDialog: {
        title: '留言客服和用户对话列表',
        visible: false,
        list: null,
        count: 0,
        chat: null,
        where: { 'customer': '', 'user': '', 'page': 1, 'limit': 6 }
      }
    }
  },
  created() {
    this.fetchData()
  },
  methods: {
    chat(index) {
      // 查看留言客服和用户对话列表
      const chat = this.userDialog.list[index]
      this.chatDialog.chat = chat
      this.chatDialog.where.user = chat.user
      this.chatDialog.where.customer = this.userDialog.user.customer
      this.chatDialog.where.page = 1
      this.chatDialog.title = this.userDialog.user.admin_name + '客服和' + chat.user + '用户的聊天记录'
      this.chatDialog.visible = true
      this.getChats()
    },
    getChats() {
      // 获取留言客服和用户对话列表
      var that = this
      GetChats(that.chatDialog.where).then(res => {
        that.chatDialog.list = res.data.list
        that.chatDialog.count = res.data.count
      }).catch(err => {
        that.$message({ type: 'error', message: err || '获取失败' })
      })
    },
    pageSizeChangeChat() {
      // 分页修改每页条数触发
      console.log('pageSizeChange Chat')
    },
    pageCurrentChangeChat(page) {
      // 跳转页面触发
      this.chatDialog.where.page = page
      this.getChats()
    },
    pagePrevClickChat(page) {
      // 上一页触发
      this.chatDialog.where.page = page
      this.getChats()
    },
    pageNextClickChat(page) {
      // 下一页触发
      this.chatDialog.where.page = page
      this.getChats()
    },
    user(index) {
      // 查看留言用户列表
      const user = this.list[index]
      this.userDialog.user = user
      this.userDialog.where.customer = user.customer
      this.userDialog.where.page = 1
      this.userDialog.title = user.admin_name + '的用户聊天记录'
      this.userDialog.visible = true
      this.getUsers()
    },
    getUsers() {
      // 获取留言用户列表
      var that = this
      GetUsers(that.userDialog.where).then(res => {
        that.userDialog.list = res.data.list
        that.userDialog.count = res.data.count
      }).catch(err => {
        that.$message({ type: 'error', message: err || '获取失败' })
      })
    },
    pageSizeChangeUser() {
      // 分页修改每页条数触发
      console.log('pageSizeChange User')
    },
    pageCurrentChangeUser(page) {
      // 跳转页面触发
      this.userDialog.where.page = page
      this.getUsers()
    },
    pagePrevClickUser(page) {
      // 上一页触发
      this.userDialog.where.page = page
      this.getUsers()
    },
    pageNextClickUser(page) {
      // 下一页触发
      this.userDialog.where.page = page
      this.getUsers()
    },
    pageSizeChange() {
      // 分页修改每页条数触发
      console.log('pageSizeChange')
    },
    pageCurrentChange(page) {
      // 跳转页面触发
      this.where.page = page
      this.fetchData()
    },
    pagePrevClick(page) {
      // 上一页触发
      this.where.page = page
      this.fetchData()
    },
    pageNextClick(page) {
      // 下一页触发
      this.where.page = page
      this.fetchData()
    },
    fetchData() {
      // 获取留言列表
      var that = this
      that.listLoading = true
      GetList(that.where).then(response => {
        that.list = response.data.list
        that.count = response.data.count
        that.listLoading = false
      }).catch(err => {
        that.$message({ type: 'error', message: err || '获取失败' })
      })
    }
  }
}
</script>
<style lang="scss" scoped>
  .page-class{
    text-align: center;
    margin-top: 10px;
  }
  .edit-dialog-form{
    margin-top: 20px;
    .el-input{
      width: 80%;
    }
  }
  .insert-button{
      text-align: right;
      margin-bottom: 10px;
  }
</style>
