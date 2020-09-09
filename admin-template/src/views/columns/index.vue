<template>
  <div class="app-container">
    <el-row :gutter="24">
      <el-form :model="where" @submit.native.prevent>
        <el-col :span="16">
          <el-form-item label="父级栏目">
            <el-select v-model="where.parent_id" @change="setWhereParentId" placeholder="请选择父级栏目">
              <el-option label="顶级栏目" value="0"></el-option>
              <el-option :label="item.name" :value="item.id" :key="item.id" v-for="item in columnsList"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-form>
      <el-col :span="8" class="insert-button">
          <el-button-group>
              <el-button type="primary" plain size="small" @click="create">栏目添加</el-button>
              <el-button type="success" plain size="small" @click="fetchData">刷新列表</el-button>
          </el-button-group>
      </el-col>
    </el-row>
    <el-table v-loading="listLoading" :data="list" element-loading-text="Loading" border fit highlight-current-row >
      <template slot="empty">暂无栏目</template>
      <el-table-column align="center" label="编号" width="80">
        <template slot-scope="scope">{{ scope.row.id }}</template>
      </el-table-column>
      <el-table-column label="信息">
        <template slot-scope="scope"><span>名称：{{ scope.row.name }}<br/>别名：{{ scope.row.name_alias }}</span></template>
      </el-table-column>
      <el-table-column label="关键字">
        <template slot-scope="scope">{{ scope.row.keywords }}</template>
      </el-table-column>
      <el-table-column align="center" label="权重" width="60">
        <template slot-scope="scope">{{ scope.row.weight }}</template>
      </el-table-column>
      <el-table-column align="center" label="信息排序">
        <template slot-scope="scope"><el-tag :type="scope.row.sort | sortTypeFilter" class="cursor">{{ scope.row.sort| sortFilter }}</el-tag></template>
      </el-table-column>
      <el-table-column align="center" label="导航状态" width="80">
        <template slot-scope="scope"><el-tag :type="scope.row.navigation | navigationTypeFilter" class="cursor">{{ scope.row.navigation| navigationFilter }}</el-tag></template>
      </el-table-column>
      <el-table-column align="center" label="操作" width="160">
        <template slot-scope="scope">
            <el-button-group>
              <el-button type="primary" icon="el-icon-edit" circle @click="editDialog(scope.$index)"></el-button>
              <el-button type="success" icon="el-icon-postcard" circle @click="editContentDialog(scope.row.id, scope.row.name)"></el-button>
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
        <el-form-item label="名称">
          <el-input v-model="editInfo.name"></el-input>
        </el-form-item>
        <el-form-item label="别名">
          <el-input v-model="editInfo.name_alias"></el-input>
        </el-form-item>
        <el-form-item label="父级栏目">
            <el-select v-model="editInfo.parent_id" placeholder="父级栏目" filterable>
              <el-option label="顶级栏目" :value="0"></el-option>
              <el-option :label="item.name" :value="item.id" :key="item.id" v-for="item in columnsList"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="图片">
          <upload-image :images="image" :name="imageName" :path="imagePath" @setImagePath="setImagePath"/>
        </el-form-item>
        <el-form-item label="banner图片">
          <upload-image :images="bannerImage" :name="bannerImageName" :path="bannerImagePath" @setImagePath="setBannerImagePath"/>
        </el-form-item>
        <el-form-item label="关键字">
          <el-input v-model="editInfo.keywords"></el-input>
        </el-form-item>
        <el-form-item label="描述">
          <el-input v-model="editInfo.description"></el-input>
        </el-form-item>
        <el-form-item label="权重">
          <el-input v-model="editInfo.weight" type="number"></el-input>
        </el-form-item>
        <el-form-item label="信息每页条数(值为0时，信息栏目列表页不查询)">
          <el-input v-model="editInfo.limit" type="number"></el-input>
        </el-form-item>
        <el-form-item label="信息排序">
            <el-select v-model="editInfo.sort" placeholder="信息排序" filterable>
              <el-option label="编号倒叙" value="0"></el-option>
              <el-option label="修改时间升序" value="1"></el-option>
              <el-option label="修改时间倒叙" value="2"></el-option>
              <el-option label="权重升序" value="3"></el-option>
              <el-option label="权重倒叙" value="4"></el-option>
              <el-option label="点击量升序" value="5"></el-option>
              <el-option label="点击量降序" value="6"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="导航状态">
          <el-radio-group v-model="editInfo.navigation">
            <el-radio label="1">展示</el-radio>
            <el-radio label="0">隐藏</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="渲染类型">
          <el-radio-group v-model="editInfo.render" @change="setRenderType">
            <el-radio label="1">超链</el-radio>
            <el-radio label="0">页面</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="页面">
            <el-input v-model="editInfo.page" v-show="renderType === false" type="url"></el-input>
            <el-select v-model="editInfo.page" placeholder="页面" filterable v-show="renderType === true">
              <el-option :label="item.name" :value="item.path" :key="item.path" v-for="item in viewsList"></el-option>
            </el-select>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogCancel">取 消</el-button>
        <el-button type="primary" @click="dialogSubmit">确 定</el-button>
      </span>
    </el-dialog>
    <el-dialog :title="editContent.title" :visible.sync="editContent.visibleMarkdown" width="60%" :before-close="editContentHandleClose" class="dialog-visible-content">
      <markdown :contentMarkdown="editContent.content.markdown" @setContent="editContentSet" :name="editContent.contentImageName" :path="editContent.contentImagePath"></markdown>
      <span slot="footer">
        <el-button type="primary" @click="editContentOrImagesSubmit">确 定</el-button>
      </span>
    </el-dialog>
    <el-dialog :modal="false" :title="editContent.title" :visible.sync="editContent.visibleTinyMCE" width="60%" :before-close="editContentHandleClose" class="dialog-visible-content-tiny-mce">
      <tiny-mce-editor :content="editContent.content.content" :name="editContent.contentImageName" :path="editContent.contentImagePath" @setContent="editContentSet"></tiny-mce-editor>
      <span slot="footer">
        <el-button type="primary" @click="editContentOrImagesSubmit">确 定</el-button>
      </span>
    </el-dialog>
  </div>
  
</template>

<script>
import { GetList, SetInsert, SetUpdate, SetDelete, GetMessage, content, GetColumns, GetViews } from '@/api/columns'
import UploadImage from '@/components/UploadImage'
import TinyMceEditor from '@/components/TinyMceEditor'
import Markdown from '@/components/Markdown'

export default {
  components: {
    UploadImage,
    TinyMceEditor,
    Markdown
  },
  filters: {
    navigationFilter(navigation) {
      var navigationArr = ['否', '是']
      return navigationArr[navigation]
    },
    navigationTypeFilter(navigation) {
      var navigationArr = ['info', 'success']
      return navigationArr[navigation]

    },
    sortFilter(sort) {
      var sortArr = ['编号倒叙', '修改时间升序', '修改时间倒叙', '权重升序', '权重倒叙', '点击量升序', '点击量降序']
      return sortArr[sort]
    },
    sortTypeFilter(sort) {
      var sortTypeArr = ['success', 'success', 'success', 'success', 'success', 'success', 'success']
      return sortTypeArr[sort]
    }
  },
  data() {
    return {
      imageUrl: '',
      image: '',
      imageName: 'columns',
      imagePath: 'columns',
      bannerImage: '',
      bannerImageName: 'columns_banner',
      bannerImagePath: 'columns_banner',
      where: { 'page': 1, 'limit': 6, 'parent_id' : '0' },
      list: null,
      count: 0,
      listLoading: true,
      dialogTitle: '添加',
      dialogVisible: false,
      dialogType: 'insert',
      renderType: true,
      editInfo: { 'id': 0, 'name': '', 'name_alias': '', 'parent_id': '0', 'image': '', 'banner_image': '', 'keywords': '', 'description': '', 'weight': '', 'limit': 10, 'sort': '', 'navigation': '', 'render': '', 'page': '' },
      columnsList: [],
      viewsList: [],
      editContent: {
        title: '修改栏目内容',
        visibleTinyMCE: false,
        visibleMarkdown: false,
        contentImageName: 'messagescontent',
        contentImagePath: 'messagescontent',
        images: [],
        content: {
          'id' : 0,
          'content' : '',
          'markdown' : '',
          'type': 0
        }
      }
    }
  },
  created() {
    this.imageUrl = process.env.VUE_APP_BASE_URL
    this.getColumns()
    this.getViews()
    this.fetchData()
  },
  methods: {
    editContentSet(content, render) {
      var that = this
      if(that.editContent.visibleTinyMCE){
        //富文本编辑框
        that.editContent.content.content = render.activeEditor.getContent()
        that.editContent.content.markdown = ''
      }else{
        // 修改内容markdown编辑框的回调
        that.editContent.content.markdown = content
        that.editContent.content.content = render
      }
    },
    editContentOrImagesSubmit() {
      // 提交修改内容
      var that = this
      that.editContent.content.type = 0
      content(that.editContent.content).then(res=>{
          that.$message({ type: 'success', message: res.msg || '添加成功' })
      }).catch(err=>{
          that.$message({ type: 'error', message: err || '保存失败' })    
      })
    },
    editContentHandleClose(done) {
      // 内容关闭前的回调
      var that = this
      this.$confirm('您要关闭' + that.editContent.title + '窗口吗?关闭后如果修改后的内容没有保存就会消失，请先保存后再关闭。', '提示', {
          confirmButtonText: '已保存，继续关闭',
          cancelButtonText: '未保存，取消关闭',
          type: 'warning'
        }).then(() => {
          that.editContent.content.id = 0
          that.editContent.content.markdown = ''
          that.editContent.content.images = []
          that.editContent.content.content = ''
          that.editContent.content.type = 0
          done()
        }).catch(() => {
          that.$message({ type: 'info', message: '取消关闭' })    
        })
    },
    editContentDialog(id, name) {
      // 添加内容
      var that = this
      this.getContent(id, function(data) {
        that.editContent.title = '【' + name + '】内容添加/修改'
        if(data.markdown.length > 0){
            // Markdown编辑器
            that.editContent.visibleMarkdown = true
        }else if(data.content.length > 0){
            // 富文本编辑器
            that.editContent.visibleTinyMCE = true
        }else{
          // 提示选择编辑器
          that.$confirm('请选择内容编辑器类型，注意：Markdown编辑器需要会Markdown语法', '提示', {closeOnPressEscape: false, showClose: false, confirmButtonText: 'Markdown', cancelButtonText: '富文本', type: 'info', center: true, roundButton: true, closeOnClickModal: false}).then(() => {
              // Markdown编辑器
              that.editContent.visibleMarkdown = true
            }).catch((action) => {
              // 富文本编辑器
              that.editContent.visibleTinyMCE = true
            })
        }
      })
    },
    
    getContent(id, callback) {
      // 获取内容
      var that = this
      that.editContent.content.id = id
      that.editContent.content.type = 1
      that.editContent.content.markdown = ''
      that.editContent.content.content = ''
      content(that.editContent.content).then(res=>{
          that.editContent.content.type = 0
          that.editContent.content.markdown = res.data.markdown
          that.editContent.content.content = res.data.content
          callback(res.data)
      }).catch(err=>{
          that.$message({ type: 'error', message: err || '获取失败' })    
      })
    },
    setRenderType() {
      // 设置页面类型
      if(this.editInfo.render === '0'){
        this.renderType = true
        this.editInfo.page = ''
      }else{
        this.renderType = false
        this.editInfo.page = ''
      }
    },
    getViews() {
      // 视图列表获取
      var that = this
      GetViews().then(res=>{
        that.viewsList = res.data
      }).catch(err=>[
          that.$message({ type: 'error', message: err })
      ])
    },
    getColumns() {
      // 栏目列表(全部)获取
      var that = this
      GetColumns().then(res=>{
        that.columnsList = res.data
      }).catch(err=>{
          that.$message({ type: 'error', message: err })
      })
    },
    setWhereParentId() {
      // 父级栏目筛选
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
    setBannerImagePath(imagePath) {
      // banner图片上传成功的路径
      var that = this
      that.bannerImage = that.imageUrl + imagePath.path
      that.editInfo.banner_image = imagePath.path
    },
    deleteDialog(index) {
      // 删除栏目
      var that = this
      var column = that.list[index]
      that.$confirm('您要永久删除【'+ column.name +'】栏目吗?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          SetDelete({id: column.id}).then(res=>{
            that.$message({ type: 'success', message: res.msg || '删除成功' })
            that.getColumns()
            that.fetchData()
          }).catch(err=>{
            that.$message({ type: 'error', message: err })
          })
        }).catch(() => {
          that.$message({ type: 'info', message: '已取消删除' })
        })
    },
    create() {
      // 添加栏目
      this.dialogTitle = '添加栏目'
      this.editInfo.id = 0
      this.editInfo.name = ''
      this.editInfo.name_alias = ''
      this.editInfo.parent_id = 0
      this.editInfo.image = ''
      this.editInfo.banner_image = ''
      this.image = ''
      this.bannerImage = ''
      this.editInfo.keywords = ''
      this.editInfo.description = ''
      this.editInfo.weight = ''
      this.editInfo.limit = 10
      this.editInfo.sort = '0'
      this.editInfo.navigation = '1'
      this.editInfo.render = '0'
      this.setRenderType()
      this.editInfo.page = ''
      this.dialogType = 'insert'
      this.dialogVisible = true
    },
    editDialog(index) {
      // 修改栏目
      var column = this.list[index]
      this.editInfo.id = column.id
      this.editInfo.name = column.name
      this.editInfo.name_alias = column.name_alias
      this.editInfo.parent_id = column.parent_id
      this.editInfo.image = column.image
      this.editInfo.banner_image = column.banner_image
      if(column.image.length > 0){
        this.image = this.imageUrl+ column.image
      }
      if(column.banner_image.length > 0){
        this.bannerImage = this.imageUrl+ column.banner_image
      }
      this.editInfo.keywords = column.keywords
      this.editInfo.description = column.description
      this.editInfo.weight = column.weight
      this.editInfo.limit = column.limit
      this.editInfo.sort = column.sort.toString()
      this.editInfo.navigation = column.navigation.toString()
      this.editInfo.render = column.render.toString()
      this.setRenderType()
      this.editInfo.page = column.page.toString()
      this.dialogTitle = '修改【' + column.name + '】栏目信息'
      this.dialogType = 'update'
      this.dialogVisible = true
    },
    dialogSubmit() {
      var that = this
      if(that.dialogType === 'update'){
        // 修改栏目 确定        
        SetUpdate(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '修改成功' })
          that.dialogVisible = false
          that.fetchData()
          that.getColumns()
        }).catch(err=>{
          that.$message({ type: 'error', message: err })
        })
      }else{
        // 添加栏目 确定
        SetInsert(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '添加成功' })
          that.dialogVisible = false
          that.fetchData()
          that.getColumns()
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
      // 修改栏目取消
      var that = this
      that.dialogVisible = false
      var message = '取消添加栏目'
      if(that.dialogType === 'update'){
        message = '取消修改栏目'
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
      // 获取栏目列表
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
  .dialog-visible-content-tiny-mce{
    z-index: 10 !important;
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
