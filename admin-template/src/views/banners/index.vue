<template>
  <div class="app-container">
    <el-row :gutter="24">
      <el-form :model="where" @submit.native.prevent>
        <el-col :span="16">
          <el-form-item label="状态">
            <el-select v-model="where.type" placeholder="请选择状态" @change="setWhereType">
              <el-option label="全部" value="" />
              <el-option label="PC" value="1" />
              <el-option label="WAP" value="2" />
            </el-select>
          </el-form-item>
        </el-col>
      </el-form>
      <el-col :span="8" class="insert-button">
        <el-button-group>
          <el-button type="primary" plain size="small" @click="create">轮播图添加</el-button>
          <el-button type="success" plain size="small" @click="fetchData">刷新列表</el-button>
        </el-button-group>
      </el-col>
    </el-row>
    <el-table v-loading="listLoading" :data="list" element-loading-text="Loading" border fit highlight-current-row>
      <template slot="empty">暂无轮播图</template>
      <el-table-column align="center" label="编号" width="95">
        <template slot-scope="scope">{{ scope.row.id }}</template>
      </el-table-column>
      <el-table-column label="名称">
        <template slot-scope="scope"><span>{{ scope.row.name }}</span></template>
      </el-table-column>
      <el-table-column label="链接">
        <template slot-scope="scope"><el-link :href="scope.row.link" target="_blank">{{ scope.row.link }}</el-link></template>
      </el-table-column>
      <el-table-column label="图片">
        <template slot-scope="scope">{{ scope.row.image }}</template>
      </el-table-column>
      <el-table-column label="权重">
        <template slot-scope="scope">{{ scope.row.weight }}</template>
      </el-table-column>
      <el-table-column label="状态">
        <template slot-scope="scope"><el-tag :type="scope.row.type | typeTypeFilter" class="cursor">{{ scope.row.type| typeFilter }}</el-tag></template>
      </el-table-column>
      <el-table-column align="center" label="添加时间">
        <template slot-scope="scope"><i class="el-icon-time" /><span>{{ scope.row.add_time | timeFilter }}</span></template>
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
        <el-form-item label="名称">
          <el-input v-model="editInfo.name" />
        </el-form-item>
        <el-form-item label="链接">
          <el-input v-model="editInfo.link" />
        </el-form-item>
        <el-form-item label="图片">
          <upload-image :images="image" :name="imageName" :path="imagePath" @setImagePath="setImagePath" />
        </el-form-item>
        <el-form-item label="权重">
          <el-input v-model="editInfo.weight" type="number" />
        </el-form-item>
        <el-form-item label="状态">
          <el-radio-group v-model="editInfo.type">
            <el-radio label="1">PC</el-radio>
            <el-radio label="2">WAP</el-radio>
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
// eslint-disable-next-line no-unused-vars
import { GetList, SetInsert, SetUpdate, SetDelete, GetMessage } from '@/api/banners'
import { secondToTime } from '@/utils/time'
import UploadImage from '@/components/UploadImage'

export default {
  components: {
    UploadImage
  },
  filters: {
    typeFilter(type) {
      var typeArr = ['未知', 'PC', 'WAP']
      return typeArr[type]
    },
    typeTypeFilter(type) {
      var typeTypeArr = ['error', 'info', 'success']
      return typeTypeArr[type]
    },
    timeFilter(second) {
      return secondToTime(second)
    }
  },
  data() {
    return {
      imageUrl: '',
      image: '',
      imageName: 'banners',
      imagePath: 'banners',
      where: { 'page': 1, 'limit': 6, 'type': '' },
      list: null,
      count: 0,
      listLoading: true,
      dialogTitle: '添加',
      dialogVisible: false,
      dialogType: 'insert',
      editInfo: { 'id': 0, 'name': '', 'link': '', 'image': '', 'weight': '', 'type': '' }
    }
  },
  created() {
    this.imageUrl = process.env.VUE_APP_BASE_URL
    this.fetchData()
  },
  methods: {
    setWhereType() {
      // 轮播图类型
      var that = this
      that.where.page = 1
      that.fetchData()
    },
    setImagePath(imagePath) {
      // 图片上传成功的路径
      var that = this
      that.image = that.imageUrl + imagePath.path
      that.editInfo.image = imagePath.path
    },
    deleteDialog(index) {
      // 删除轮播图
      var that = this
      var banners = that.list[index]
      that.$confirm('您要永久删除【' + banners.name + '】轮播图吗?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        SetDelete({ id: banners.id }).then(res => {
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
      // 添加轮播图
      this.dialogTitle = '添加轮播图'
      this.editInfo.id = 0
      this.editInfo.name = ''
      this.editInfo.link = ''
      this.editInfo.image = ''
      this.image = ''
      this.editInfo.weight = ''
      this.editInfo.type = '1'
      this.dialogType = 'insert'
      this.dialogVisible = true
    },
    editDialog(index) {
      // 修改轮播图
      var banners = this.list[index]
      this.editInfo.id = banners.id
      this.editInfo.name = banners.name
      this.editInfo.link = banners.link
      this.editInfo.image = banners.image
      this.image = this.imageUrl + banners.image
      this.editInfo.weight = banners.weight
      this.editInfo.type = banners.type.toString()
      this.dialogTitle = '修改【' + banners.name + '】轮播图信息'
      this.dialogType = 'update'
      this.dialogVisible = true
    },
    dialogSubmit() {
      var that = this
      if (that.dialogType === 'update') {
        // 修改轮播图 确定
        SetUpdate(that.editInfo).then(res => {
          that.$message({ type: 'success', message: res.msg || '修改成功' })
          that.dialogVisible = false
          that.fetchData()
        }).catch(err => {
          that.$message({ type: 'error', message: err })
        })
      } else {
        // 添加轮播图 确定
        SetInsert(that.editInfo).then(res => {
          that.$message({ type: 'success', message: res.msg || '添加成功' })
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
      // 修改轮播图取消
      var that = this
      that.dialogVisible = false
      var message = '取消添加轮播图'
      if (that.dialogType === 'update') {
        message = '取消修改轮播图'
      }
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
      // 获取轮播图列表
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
