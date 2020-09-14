<template>
  <div class="app-container">
    <el-row :gutter="24">
      <el-form :model="where" @submit.native.prevent>
        <el-col :span="8"><el-form-item label="账号"><el-input v-model="where.username" class="where-username" @change="setWhereUserName" /></el-form-item></el-col>
      </el-form>
      <el-col :span="16" class="insert-button">
        <el-button-group>
          <el-button type="primary" plain size="small" @click="create">管理员添加</el-button>
          <el-button type="success" plain size="small" @click="fetchData">刷新列表</el-button>
        </el-button-group>
      </el-col>
    </el-row>
    <el-table v-loading="listLoading" :data="list" element-loading-text="Loading" border fit highlight-current-row>
      <template slot="empty">暂无管理员</template>
      <el-table-column align="center" label="编号" width="95">
        <template slot-scope="scope">{{ scope.row.id }}</template>
      </el-table-column>
      <el-table-column label="管理员名称">
        <template slot-scope="scope"><span>{{ scope.row.real_name }}</span></template>
      </el-table-column>
      <el-table-column label="管理员账号">
        <template slot-scope="scope">{{ scope.row.username }}</template>
      </el-table-column>
      <el-table-column label="管理员规则" align="center">
        <template slot-scope="scope"><span>{{ scope.row.rulename }}{{ scope.row.rule_id > 0 ? '/' + scope.row.rule_id : '' }}</span></template>
      </el-table-column>
      <el-table-column label="管理员邮箱" align="center">
        <template slot-scope="scope">{{ scope.row.email }}</template>
      </el-table-column>
      <el-table-column class-name="status-col" label="管理员状态" align="center">
        <template slot-scope="scope"><el-tag class="cursor" :type="scope.row.status | statusTypeFilter">{{ scope.row.status| statusFilter }}</el-tag></template>
      </el-table-column>
      <el-table-column align="center" label="添加时间">
        <template slot-scope="scope"><i class="el-icon-time" /><span>{{ scope.row.add_time | timeFilter }}</span></template>
      </el-table-column>
      <el-table-column align="center" label="最后登录时间">
        <template slot-scope="scope"><i class="el-icon-time" /><span>{{ scope.row.last_time | timeFilter }}</span></template>
      </el-table-column>
      <el-table-column align="center" label="操作" width="120">
        <template slot-scope="scope">
          <el-button-group>
            <el-button type="primary" icon="el-icon-edit" circle @click="editDialog(scope.$index)" />
            <el-button type="success" icon="el-icon-delete" circle @click="deleteDialog(scope.$index)" />
          </el-button-group>
        </template>
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
    <el-dialog :title="dialogTitle" :visible.sync="dialogVisible" :before-close="dialogBeforeClosed" width="60%" center>
      <el-form class="edit-dialog-form">
        <el-form-item label="管理员账号">
          <el-input v-model="editInfo.username" />
        </el-form-item>
        <el-form-item label="管理员密码">
          <el-input v-model="editInfo.password" />
        </el-form-item>
        <el-form-item label="管理员名称">
          <el-input v-model="editInfo.real_name" />
        </el-form-item>
        <el-form-item label="管理员状态">
          <el-radio-group v-model="editInfo.status">
            <el-radio label="1">显示</el-radio>
            <el-radio label="0">锁定</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="管理员创建">
          <el-radio-group v-model="editInfo.found">
            <el-radio label="1">是</el-radio>
            <el-radio label="0">否</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="管理员规则">
          <el-select v-model="editInfo.rule_id" placeholder="管理员规则">
            <el-option v-for="item in rulesIds" :key="item.id" :label="item.name" :value="item.id" />
          </el-select>
        </el-form-item>
        <el-form-item label="管理员邮箱">
          <el-input v-model="editInfo.email" />
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogCancel">取 消</el-button>
        <el-button type="primary" @click="dialogSubmit">确 定</el-button>
      </span>
    </el-dialog>
  </div>

</template>

<script>
// eslint-disable-next-line no-unused-vars
import { GetList, SetInsert, SetUpdate, SetDelete, GetMessage } from '@/api/admins'
import { GetRules } from '@/api/rules'
import { setMenusToken } from '@/utils/auth'
import { secondToTime } from '@/utils/time'

export default {
  filters: {
    statusFilter(status) {
      var statusArr = ['锁定', '显示']
      return statusArr[status]
    },
    statusTypeFilter(status) {
      var statusTypeArr = ['danger', 'success']
      return statusTypeArr[status]
    },
    timeFilter(second) {
      return secondToTime(second)
    }
  },
  data() {
    return {
      where: { 'page': 1, 'limit': 6, 'username': '' },
      list: null,
      rulesIds: [],
      count: 0,
      listLoading: true,
      dialogTitle: '修改',
      dialogVisible: false,
      dialogType: 'insert',
      editInfo: {
        'id': 0,
        'username': '',
        'password': '',
        'real_name': '',
        'status': '0',
        'found': '0',
        'rule_id': '',
        'email': ''
      }
    }
  },
  created() {
    this.fetchData()
    this.rulesList()
  },
  methods: {
    deleteDialog(index) {
      // 删除管理员
      var that = this
      var admin = that.list[index]
      that.$confirm('您要永久删除【' + admin.real_name + '】管理员吗?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        SetDelete({ id: admin.id }).then(res => {
          that.$message({ type: 'success', message: res.msg || '删除成功' })
          that.fetchData()
        }).catch(err => {
          that.$message({ type: 'error', message: err })
        })
      }).catch(() => {
        that.$message({ type: 'info', message: '已取消删除' })
      })
    },
    create() {
      this.dialogTitle = '添加管理员'
      this.editInfo.id = 0
      this.editInfo.username = ''
      this.editInfo.password = ''
      this.editInfo.real_name = ''
      this.editInfo.status = '0'
      this.editInfo.found = '0'
      this.editInfo.rule_id = ''
      this.editInfo.email = ''
      this.dialogType = 'insert'
      this.dialogVisible = true
    },
    editDialog(index) {
      // 修改管理员信息
      var current = this.list[index]
      this.editInfo.id = current.id
      this.editInfo.real_name = current.real_name
      this.editInfo.username = current.username
      this.editInfo.password = ''
      this.editInfo.email = current.email
      this.editInfo.status = current.status.toString()
      this.editInfo.rule_id = current.rule_id
      this.dialogTitle = '修改【' + current.real_name + '】管理员信息'
      this.dialogType = 'update'
      this.dialogVisible = true
    },
    dialogSubmit() {
      var that = this
      if (that.dialogType === 'update') {
        // 修改管理员信息 确定
        SetUpdate(that.editInfo).then(res => {
          that.$message({ type: 'success', message: res.msg || '修改成功' })
          setMenusToken('false')
          that.dialogVisible = false
          that.fetchData()
        }).catch(err => {
          that.$message({ type: 'error', message: err })
        })
      } else {
        // 添加管理员信息 确定
        SetInsert(that.editInfo).then(res => {
          that.$message({ type: 'success', message: res.msg || '添加成功' })
          setMenusToken('false')
          that.dialogVisible = false
          that.fetchData()
        }).catch(err => {
          that.$message({ type: 'error', message: err })
        })
      }
    },
    dialogBeforeClosed(done) {
      // 修改、添加窗口未点击取消和确定按钮关闭回调
      var that = this
      that.$confirm('您要当前窗口吗?关闭后没有保存的数据就会消失,请先保存后再关闭。', '提示', {
        confirmButtonText: '已保存，继续关闭',
        cancelButtonText: '未保存，取消关闭',
        type: 'warning'
      }).then(() => {
        done()
      }).catch(() => {
        that.$message({ type: 'info', message: '取消关闭' })
      })
    },
    dialogCancel() {
      // 修改管理员信息取消
      var that = this
      that.dialogVisible = false
      var message = '取消添加管理员'
      if (that.dialogType === 'update') {
        message = '取消修改管理员'
      }
      that.$message({ type: 'warning', message: message })
    },
    setWhereUserName() {
      // 管理员账号搜索
      var that = this
      that.where.page = 1
      that.fetchData()
    },
    pageSizeChange() {
      // 分页修改每页条数触发
      console.log('pageSizeChange')
    },
    pageCurrentChange(page) {
      // 跳转页面触发
      var that = this
      that.where.page = page
      that.fetchData()
    },
    pagePrevClick(page) {
      // 上一页触发
      console.log(page)
      console.log('pagePrevClick')
    },
    pageNextClick(page) {
      // 下一页触发
      console.log(page)
      console.log('pageNextClick')
    },
    rulesList() {
      // 获取规则名称和编号
      var that = this
      GetRules().then(res => {
        that.rulesIds = res.data
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    fetchData() {
      // 获取管理员列表
      var that = this
      that.listLoading = true
      GetList(that.where).then(response => {
        that.list = response.data.list
        that.count = response.data.count
        that.listLoading = false
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    }
  }
}
</script>
<style lang="scss" scoped>
  .where-username{
    width: 80%
  }
  .cursor{
    cursor: pointer;
  }
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
      margin-top: 10px;
  }
</style>
