<template>
  <div class="app-container">
    <el-row :gutter="24">
      <el-form :model="where" @submit.native.prevent>
        <el-col :span="8" v-if="menus.length > 0">
          <el-form-item label="菜单父级">
            <el-select v-model="where.parent_id" @change="setWhereParentId" filterable placeholder="请选择父级菜单">
              <el-option v-for="item in menus" :label="item.name" :value="item.id" :key="item.id"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="8">
          <el-form-item label="菜单类型">
            <el-select v-model="where.menu" @change="setWhereMenu" placeholder="请选择菜单类型">
              <el-option label="全部菜单" value="0"></el-option>
              <el-option label="路由菜单" value="1"></el-option>
              <el-option label="页面菜单" value="2"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-form>
      <el-col :span="8" class="insert-button">
          <el-button-group>
              <el-button type="primary" plain size="small" @click="create">菜单添加</el-button>
              <el-button type="success" plain size="small" @click="fetchData">刷新列表</el-button>
          </el-button-group>
      </el-col>
    </el-row>
    <el-table v-loading="listLoading" :data="list" element-loading-text="Loading" border fit highlight-current-row >
      <template slot="empty">暂无菜单</template>
      <el-table-column align="center" label="编号" width="95">
        <template slot-scope="scope">{{ scope.row.id }}</template>
      </el-table-column>
      <el-table-column label="菜单名称">
        <template slot-scope="scope"><span class="cursor" @click="setChildren(scope.row.id)">{{ scope.row.name }}</span></template>
      </el-table-column>
      <el-table-column label="访问地址">
        <template slot-scope="scope">{{ scope.row.routes }}</template>
      </el-table-column>
      <el-table-column label="访问页面" align="center">
        <template slot-scope="scope"><span>{{ scope.row.page }}</span></template>
      </el-table-column>
      <el-table-column label="菜单icon" align="center">
        <template slot-scope="scope">{{ scope.row.icon }}</template>
      </el-table-column>
      <el-table-column label="菜单排序" align="center">
        <template slot-scope="scope">{{ scope.row.sort }}</template>
      </el-table-column>
      <el-table-column class-name="status-col" label="菜单状态" align="center">
        <template slot-scope="scope"><el-tag :type="scope.row.menu | menuTypeFilter" class="cursor">{{ scope.row.menu| menuFilter }}</el-tag></template>
      </el-table-column>
      <el-table-column align="center" label="添加时间">
        <template slot-scope="scope"><i class="el-icon-time" /><span>{{ scope.row.add_time | timeFilter }}</span></template>
      </el-table-column>
      <el-table-column align="center" label="操作" width="120">
        <template slot-scope="scope">
            <el-button-group>
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
    <el-dialog :title="dialogTitle" :visible.sync="dialogVisible" :before-close="dialogBeforeClosed" width="60%" center>
      <el-form class="edit-dialog-form">
        <el-form-item label="菜单名称">
          <el-input v-model="editInfo.name"></el-input>
        </el-form-item>
        <el-form-item label="路由地址">
          <el-input v-model="editInfo.routes"></el-input>
        </el-form-item>
        <el-form-item label="页面链接">
          <el-input v-model="editInfo.page"></el-input>
        </el-form-item>
        <el-form-item label="父级菜单">
            <el-select v-model="editInfo.parent_id" placeholder="父级菜单" filterable>
              <el-option v-for="item in menus" :label="item.name" :value="item.id" :key="item.id"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="菜单icon">
          <el-input v-model="editInfo.icon"></el-input>
        </el-form-item>
        <el-form-item label="菜单排序">
          <el-input v-model="editInfo.sort"></el-input>
        </el-form-item>
        <el-form-item label="菜单类型">
          <el-radio-group v-model="editInfo.menu">
            <el-radio label="1">页面菜单</el-radio>
            <el-radio label="0">路由菜单</el-radio>
          </el-radio-group>
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
import { GetList, SetInsert, SetUpdate, SetDelete, GetMessage, GetMenus} from '@/api/menus'
import { setMenusToken } from '@/utils/auth'
import { secondToTime } from '@/utils/time'
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters([
      'admin'
    ]),
  },
  filters: {
    menuFilter(menu) {
      var menuArr = ['路由菜单', '页面菜单']
      return menuArr[menu]
    },
    menuTypeFilter(menu) {
      var menuTypeArr = ['danger', 'success']
      return menuTypeArr[menu]
    },
    timeFilter(second) {
      return secondToTime(second)
    }
  },
  data() {
    return {
      where: {
        'page': 1,
        'limit': 6,
        'menu': "0",
        'parent_id': 0
      },
      list: null,
      menus: [],
      count: 0,
      listLoading: true,
      dialogTitle: '添加',
      dialogVisible: false,
      dialogType: 'insert',
      editInfo: {
        'id': 0,
        'name': '',
        'routes': '',
        'page': '',
        'parent_id': 0,
        'icon': '',
        'sort': 1,
        'menu': '0',
      }
    }
  },
  created() {
    this.fetchData()
    this.menusList()
  },
  methods: {
    deleteDialog(index) {
      // 删除菜单
      var that = this
      var menu = that.list[index]
      that.$confirm('您要永久删除【'+ menu.name +'】菜单吗?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          SetDelete({id: menu.id}).then(res=>{
            that.$message({ type: 'success', message: res.msg || '删除成功' })
            that.fetchData()
          }).catch(err=>{
            that.$message({ type: 'error', message: err })
          })
        }).catch(() => {
          that.$message({ type: 'info', message: '已取消删除' })
        })
    },
    create() {
      this.dialogVisible = true
      this.dialogTitle = '添加菜单'
      this.editInfo.id = 0
      this.editInfo.name = ''
      this.editInfo.routes = ''
      this.editInfo.page = ''
      this.editInfo.icon = ''
      this.editInfo.parent_id = 0
      this.editInfo.menu = '0'
      this.editInfo.sort = 1
      this.dialogType = 'create'
    },
    setChildren(id) {
      // 下级菜单
      this.where.parent_id = id
      this.where.page = 1
      this.menusList()
      this.fetchData()
    },
    menusList() {
      var that = this
      GetMenus({id: that.admin.id}).then(res=>{
        that.menus = res.data
        that.menus.unshift({id: 0, name: "顶级菜单", parent_id: 0})
      }).catch(err=>{
        that.$message({ type: 'error', message: err })
      })
    },
    editDialog(index) {
      // 修改菜单信息
      var that = this
      var menu = that.list[index]
      that.editInfo.id = menu.id
      that.editInfo.name = menu.name
      that.editInfo.routes = menu.routes
      that.editInfo.page = menu.page
      that.editInfo.parent_id = menu.parent_id
      that.editInfo.icon = menu.icon
      that.editInfo.sort = menu.sort
      that.editInfo.menu = menu.menu.toString()
      that.dialogVisible = true
      that.dialogTitle = '修改【'+menu.name+'】菜单信息'
      that.dialogType = 'update'
    },
    dialogSubmit() {
      // 修改菜单信息确定
      var that = this
      if(that.dialogType === 'update'){
        SetUpdate(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '修改成功' })
          that.dialogVisible = false
          that.fetchData()
          that.menusList()
          setMenusToken('false')
        }).catch(err=>{
          that.$message({ type: 'error', message: err })
        })
      }else{
        SetInsert(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '添加成功' })
          that.dialogVisible = false
          that.fetchData()
          that.menusList()
          setMenusToken('false')
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
      // 修改菜单信息取消
      var that = this
      that.dialogVisible = false
      var message = '取消添加菜单'
      if(that.dialogType === 'update'){
        message = '取消修改菜单'
      }
      that.$message({ type: 'warning', message: message })
    },
    setWhereMenu() {
      // 菜单状态搜索
      var that = this
      that.where.page = 1
      that.fetchData()
    },
    setWhereParentId() {
      // 父级菜单搜索
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
    fetchData() {
      // 获取菜单列表
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
