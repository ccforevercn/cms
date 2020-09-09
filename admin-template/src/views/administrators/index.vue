<template>
  <div class="app-container">
    <el-form class="edit-dialog-form">
        <el-form-item label="账号">
          <el-input v-model="admin.username" :disabled="true"></el-input>
        </el-form-item>
        <el-form-item label="密码">
          <el-input v-model="admin.password" placeholder="不填写密码既不修改"></el-input>
        </el-form-item>
        <el-form-item label="名称">
          <el-input v-model="admin.real_name"></el-input>
        </el-form-item>
        <el-form-item label="状态">
          <el-radio-group v-model="admin.status">
            <el-radio label="1">显示</el-radio>
            <el-radio label="0">锁定</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="创建">
          <el-radio-group v-model="admin.found">
            <el-radio label="1">是</el-radio>
            <el-radio label="0">否</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="规则">
            <el-select v-model="admin.rule_id" placeholder="规则">
              <el-option v-for="item in rulesIds" :label="item.name" :value="item.id" :key="item.id"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="邮箱">
          <el-input v-model="admin.email"></el-input>
        </el-form-item>
    </el-form>
    <span slot="footer" class="dialog-footer">
      <el-button type="primary" @click="dialogSubmit">修改信息</el-button>
    </span>
  </div>
</template>

<script>
import { SetUpdate, GetMessage } from '@/api/admins'
import { GetRules } from '@/api/rules'
import { setMenusToken, setAdminStatus, getAdminUnique } from '@/utils/auth'
export default {
  data() {
    return {
      rulesIds: [],
      adminId: 0,
      admin: {
        'id': 0,
        'username' : '',
        'password' : '',
        'real_name' : '',
        'status' : '0',
        'found' : '0',
        'rule_id' : '',
        'email' : ''
      }
    }
  },
  created() {
    this.adminId = getAdminUnique()
    if(this.adminId < 1){ 
      this.$message({ type: 'error', message: '参数错误' }) 
      store.dispatch('user/resetToken')
      this.$router.push({ path: '/login' })
    }
    this.rulesList()
    this.getMessage()
  },
  methods: {
    dialogSubmit() {
      var that = this
      // 修改管理员信息
        that.admin.id = that.adminId
      SetUpdate(that.admin).then(res=>{
        that.$message({ type: 'success', message: res.msg || '修改成功' })
        setMenusToken('false')
        setAdminStatus('false')
        that.dialogVisible = false
        that.fetchData()
      }).catch(err=>{
        that.$message({ type: 'error', message: err })
      })
    },
    rulesList() {
      // 获取规则名称和编号
      var that = this
      GetRules().then(res=>{        
        that.rulesIds = res.data
      }).catch(err=>{
        that.$message({ type: 'error', message: err })
      })
    },
    getMessage() {
      var that = this
      GetMessage({id: that.adminId}).then(res=>{        
        let admin = res.data
        that.admin.username = admin.username
        that.admin.real_name = admin.real_name
        that.admin.status = admin.status.toString()
        that.admin.found = admin.found.toString()
        that.admin.rule_id = admin.rule_id
        that.admin.email = admin.email
      }).catch(err=>{
        that.$message({ type: 'error', message: err })
      })
    }
  }
}
</script>
<style lang="scss" scoped>
  .edit-dialog-form{
    margin-top: 20px;
    .el-input{
      width: 80%;
    }
  }
  .dialog-footer{
    width: 100%;
  }
</style>
