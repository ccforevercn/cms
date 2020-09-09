<template>
  <div class="app-container">
    <el-row :gutter="24">
      <el-col class="insert-button" v-if="treeMenusStatus === true">
          <el-button-group>
              <el-button type="primary" plain size="small" @click="create">规则添加</el-button>
              <el-button type="success" plain size="small" @click="fetchData">刷新列表</el-button>
          </el-button-group>
      </el-col>
    </el-row>
    <el-table v-loading="listLoading" :data="list" element-loading-text="Loading" border fit highlight-current-row>
      <template slot="empty">暂无规则</template>
      <el-table-column align="center" label="编号" width="95">
        <template slot-scope="scope">
          {{ scope.row.id }}
        </template>
      </el-table-column>
      <el-table-column label="规则名称">
        <template slot-scope="scope">
          {{ scope.row.name }}
        </template>
      </el-table-column>
      <el-table-column label="管理员">
        <template slot-scope="scope">
          {{ scope.row.admin_name }}/{{ scope.row.admin_id }}
        </template>
      </el-table-column>
      <el-table-column align="center" label="添加时间">
        <template slot-scope="scope">
          <i class="el-icon-time" />
          <span>{{ scope.row.add_time | timeFilter }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="操作" width="200">
        <template slot-scope="scope">          
            <el-button-group>
              <el-button type="info" icon="el-icon-s-operation" circle @click="menusDialog(scope.$index)"></el-button>
              <el-button type="primary" icon="el-icon-edit" circle @click="editDialog(scope.$index)"></el-button>
              <el-button type="success" icon="el-icon-delete" circle @click="deleteDialog(scope.$index)"></el-button>
            </el-button-group>
        </template>
      </el-table-column>
    </el-table>
    <el-row :gutter="24">
      <el-col :span="24" class="page-class">
        <el-pagination
          background
          @size-change="pageSizeChange"
          @current-change="pageCurrentChange"
          @prev-click="pagePrevClick"
          @next-click="pageNextClick"
          :page-size="where.limit"
          :pager-count="5"
          layout="prev, pager, next"
          :total="count">
        </el-pagination>
      </el-col>
    </el-row>
    <el-dialog :title="dialogTitle" :visible.sync="dialogVisible" :before-close="dialogBeforeClosed" width="60%" center >
      <el-form class="edit-dialog-form">
        <el-form-item label="规则名称">
          <el-input v-model="editInfo.name"></el-input>
        </el-form-item>
        <el-form-item>
          <el-tree
            :data="treeMenusList"
            :props="treeProps"
            :node-key='treeNodeKey'
            :default-checked-keys="treeDefaultCheckedKeys"
            show-checkbox
            ref="tree"
            @check-change="treeCheckChange">
          </el-tree>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogCancel">取 消</el-button>
        <el-button type="primary" @click="dialogSubmit">确 定</el-button>
      </span>
    </el-dialog>
    <el-dialog :title="menusSee.title" :visible.sync="menusSee.visible" width="30%" center>
        <el-tree :data="menusSee.list" :props="treeProps" accordion>
        </el-tree>
    </el-dialog>
  </div>
</template>

<script>
import { GetList, SetInsert, SetUpdate, SetDelete, GetMessage, GetMenus } from '@/api/rules'
import { children } from '@/api/menus'
import { setMenusToken } from '@/utils/auth'
import { inArray, arrayKey } from '@/utils/array'
import { secondToTime } from '@/utils/time'
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters([
      'admin'
    ]),
  },
  filters: {
    timeFilter(second) {
      return secondToTime(second)
    }
  },
  data() {
    return {
      treeMenusStatus: false,
      where: { 'page': 1, 'limit': 6, 'admin_id': '' },
      list: null,
      count: 0,
      listLoading: true,
      dialogTitle: '',
      dialogVisible: false,
      dialogType: 'insert',
      treeNodeKey: 'id',
      treeMenusList: [],
      treeDefaultCheckedKeys: [],
      editInfo: { 'id': 0, 'name': '', 'menus_id': '' },
      treeProps: { children: 'children', label: 'label' },
      menusSee: { title : '', visible: false, list: [] }
    }
  },
  created() {
    this.where.admin_id = this.admin.id
    this.fetchData()
    this.ruelsMenusList()
  },
  methods: {
    deleteDialog(index) {
      // 删除规则
      var that = this
      var rule = that.list[index]
      that.$confirm('您要永久删除【'+ rule.name +'】规则吗?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          SetDelete({id: rule.id}).then(res=>{
            that.$message({ type: 'success', message: res.msg || '删除成功' })
            that.fetchData()
          }).catch(err=>{
            that.$message({ type: 'error', message: err })
          })
        }).catch(() => {
          that.$message({ type: 'info', message: '已取消删除' })
        })
    },
    resetEditInfo() {
      // 重置修改/添加数据
      var that = this
      that.editInfo.id = 0
      that.editInfo.name = ''
      that.editInfo.menus_id = ''
    },
    getMenusList(ruleId, callback) {
      // 获取指定规则菜单
      var that = this
      GetMenus({id: ruleId}).then(res=>{
        callback(res.data)
      }).catch(res=>{
        that.$message({ type: 'error', message: err })
      })
    },
    ruelsMenusList() {
      // 当前管理员的所有规则菜单
      var that = this
      that.getMenusList(that.admin.rule_id, function(data){
        that.treeMenusList = data.menus
        that.treeMenusStatus = true
      })
    },
    menusDialog(index) {
      // 规则菜单查看
      var that = this
      var rule = that.list[index]
      that.menusSee.title = '[' + rule.name + ']菜单'
      that.getMenusList(rule.id, function(data){
        that.menusSee.list = data.menus
        that.menusSee.visible = true
      })
    },
    create() {
      // 添加规则
      var that = this
      that.resetEditInfo()
      that.dialogType = 'insert'
      that.dialogTitle = '添加新规则'
      that.dialogVisible = true
      that.$nextTick(() => {
          that.$refs.tree.setCheckedNodes([])
          that.treeDefaultCheckedKeys = []
      })
    },
    treeCheckChangeChildrenPush(data) {
      // treeCheckChange调用 添加子菜单中的编号
        var that = this
        if(data.hasOwnProperty('children')){
          for(let index in data.children){
            if(!inArray(data.children[index].id, that.treeDefaultCheckedKeys, 'parseint')){
                that.treeDefaultCheckedKeys.push(data.children[index].id)
            }
            that.treeCheckChangeChildrenPush(data.children[index])
          }
        }
    },
    treeCheckChangeChildrenSplice(data) {
      // treeCheckChange调用 移除子菜单中的编号
      var that = this
      if(data.hasOwnProperty('children')){
        for(let index in data.children){
          let key = arrayKey(data.children[index].id, that.treeDefaultCheckedKeys, 'parseint')
          if(key !== undefined){
            that.treeDefaultCheckedKeys.splice(key, 1)
          }
          that.treeCheckChangeChildrenSplice(data.children[index])
        }
      }
    },
    treeCheckChange(data, checked, indeterminate) {
      // 删除/添加 菜单
      var that = this
      if(!(checked === false && indeterminate === true)){
          if(checked){ /* 节点添加 */
            if(!inArray(data.id, that.treeDefaultCheckedKeys, 'parseint')){
                that.treeDefaultCheckedKeys.push(data.id)
            }
            that.treeCheckChangeChildrenPush(data)
          }else{ /* 节点取消 */
            let key = arrayKey(data.id, that.treeDefaultCheckedKeys, 'parseint')
            if(key !== undefined){
              that.treeDefaultCheckedKeys.splice(key, 1)
            }
            that.treeCheckChangeChildrenSplice(data)
          }
          that.editInfo.menus_id = that.treeDefaultCheckedKeys.toString()
      }
    },
    editDialog(index) {
      // 修改规则信息
      var that = this
      that.resetEditInfo()
      var rule = that.list[index]
      that.editInfo.id = rule.id
      that.editInfo.name = rule.name
      that.dialogType = 'update'
      that.dialogTitle = '修改【'+ rule.name +'】规则信息'
      that.getMenusList(rule.id, function(data){
        that.dialogVisible = true
        that.$nextTick(() => {
          that.$refs.tree.setCheckedNodes([])
          that.treeDefaultCheckedKeys = data.ids
          that.editInfo.menus_id = data.ids.toString()
        })
      })
    },
    dialogSubmit() {
      var that = this
      // 确定添加/修改 规则
      if(that.dialogType === 'update'){
        // 修改规则信息
        SetUpdate(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '修改成功' })
          setMenusToken('false')
          that.dialogVisible = false
          that.fetchData()
        }).catch(err=>{
          that.$message({ type: 'error', message: err })
        })
      }else{
        // 添加规则信息
        SetInsert(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '添加成功' })
          setMenusToken('false')
          that.dialogVisible = false
          that.fetchData()
        }).catch(err=>{
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
      // 取消添加/修改规则信息
      var that = this
      var message = '取消添加规则'
      if(that.dialogType === 'update'){
        message = '取消修改规则'
      }
      that.dialogVisible = false
      that.$message({ type: 'warning', message: message })
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
    fetchData() {
      // 获取规则列表
      var that = this
      that.listLoading = true
      GetList(that.where).then(response => {
        that.list = response.data.list
        that.count = response.data.count
        that.listLoading = false
      }).catch(err=>{
        that.$message({ type: 'error', message: err })
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
