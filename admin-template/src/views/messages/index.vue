<template>
  <div class="app-container">
    <el-row :gutter="24">
      <el-form :model="where" @submit.native.prevent>
        <el-col :span="5">
          <el-form-item label="父级栏目">
            <el-select v-model="where.columns_id" @change="setWhere" placeholder="请选择父级栏目">
              <el-option label="全部栏目" value=""></el-option>
              <el-option :label="item.name" :value="item.id" :key="item.id" v-for="item in columnsList"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="5">
          <el-form-item label="首页推荐">
            <el-select v-model="where.index" @change="setWhere" placeholder="请选择首页推荐">
              <el-option label="全部" value=""></el-option>
              <el-option label="是" value="1"></el-option>
              <el-option label="否" value="0"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="5">
          <el-form-item label="热门推荐">
            <el-select v-model="where.hot" @change="setWhere" placeholder="请选择热门推荐">
              <el-option label="全部" value=""></el-option>
              <el-option label="是" value="1"></el-option>
              <el-option label="否" value="0"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="5">
          <el-form-item label="发布状态">
            <el-select v-model="where.release" @change="setWhere" placeholder="请选择发布状态">
              <el-option label="全部" value=""></el-option>
              <el-option label="是" value="1"></el-option>
              <el-option label="否" value="0"></el-option>
            </el-select>
          </el-form-item>
        </el-col>
      </el-form>
      <el-col :span="4" class="insert-button">
          <el-button-group>
              <el-button type="primary" plain size="small" @click="create">信息添加</el-button>
              <el-button type="success" plain size="small" @click="fetchData">刷新列表</el-button>
          </el-button-group>
      </el-col>
    </el-row>
    <el-table v-loading="listLoading" :data="list" element-loading-text="Loading" border fit highlight-current-row >
      <template slot="empty">暂无信息</template>
      <el-table-column align="center" label="编号" width="80">
        <template slot-scope="scope">{{ scope.row.id }}</template>
      </el-table-column>
      <el-table-column label="信息">
        <template slot-scope="scope">
          <span>标题：{{ scope.row.name }}</span><br/>
          <span>关键字：{{ scope.row.keywords }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="点击量" width="70">
        <template slot-scope="scope">{{ scope.row.click }}</template>
      </el-table-column>
      <el-table-column align="center" label="权重" width="60">
        <template slot-scope="scope">{{ scope.row.weight }}</template>
      </el-table-column>
      <el-table-column align="center" label="首页推荐" width="80">
        <template slot-scope="scope"><el-tag :type="scope.row.index | typeTypeFilter" class="cursor">{{ scope.row.index | typeFilter }}</el-tag></template>
      </el-table-column>
      <el-table-column align="center" label="热门推荐" width="80">
        <template slot-scope="scope"><el-tag :type="scope.row.hot | typeTypeFilter" class="cursor">{{ scope.row.hot | typeFilter }}</el-tag></template>
      </el-table-column>
      <el-table-column align="center" label="发布状态" width="80">
        <template slot-scope="scope"><el-tag :type="scope.row.release | typeTypeFilter" class="cursor">{{ scope.row.release | typeFilter }}</el-tag></template>
      </el-table-column>
      <el-table-column align="center" label="修改时间" width="100">
        <template slot-scope="scope">{{ scope.row.update_time | timeFilter }}</template>
      </el-table-column>
      <el-table-column align="center" label="发布时间" width="100">
        <template slot-scope="scope">{{ scope.row.release_time | timeFilter }}</template>
      </el-table-column>
      <el-table-column align="center" label="添加时间" width="100">
        <template slot-scope="scope">{{ scope.row.add_time | timeFilter }}</template>
      </el-table-column>
      <el-table-column align="center" label="操作" width="180">
        <template slot-scope="scope">
            <el-button-group>
              <el-button type="primary" icon="el-icon-edit" circle @click="editDialog(scope.$index)"></el-button>
              <el-button type="primary" icon="el-icon-picture" circle @click="editImagesDialog(scope.row.id, scope.row.name)"></el-button>
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
        <el-form-item label="栏目">
            <el-select v-model="editInfo.columns_id" placeholder="栏目" filterable>
              <el-option :label="item.name" :value="item.id" :key="item.id" v-for="item in columnsList"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="标签">
            <el-select v-model="editInfo.tags_id" placeholder="标签" filterable multiple>
              <el-option :label="item.name" :value="item.id" :key="item.id" v-for="item in tagsList"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="图片">
          <upload-image :images="image" :name="imageName" :path="imagePath" @setImagePath="setImagePath"/>
        </el-form-item>
        <el-form-item label="作者">
          <el-input v-model="editInfo.writer"></el-input>
        </el-form-item>
        <el-form-item label="点击量">
          <el-input v-model="editInfo.click" type="number"></el-input>
        </el-form-item>
        <el-form-item label="权重">
          <el-input v-model="editInfo.weight" type="number"></el-input>
        </el-form-item>
        <el-form-item label="关键字">
          <el-input v-model="editInfo.keywords"></el-input>
        </el-form-item>
        <el-form-item label="描述">
          <el-input v-model="editInfo.description"></el-input>
        </el-form-item>
        <el-form-item label="首页推荐">
          <el-radio-group v-model="editInfo.index">
            <el-radio label="1">是</el-radio>
            <el-radio label="0">否</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="热门推荐">
          <el-radio-group v-model="editInfo.hot">
            <el-radio label="1">是</el-radio>
            <el-radio label="0">否</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="是否发布">
          <el-radio-group v-model="editInfo.release">
            <el-radio label="1">是</el-radio>
            <el-radio label="0">否</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="修改时间">
            <el-date-picker v-model="editInfo.update_time" type="datetime" placeholder="选择修改时间"></el-date-picker>
        </el-form-item>
        <el-form-item label="发布时间">
            <el-date-picker v-model="editInfo.release_time" type="datetime" placeholder="选择发布时间"></el-date-picker>
        </el-form-item>
        <el-form-item label="页面">
            <el-select v-model="editInfo.page" placeholder="页面" filterable >
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
    <el-dialog :title="editContent.title" :visible.sync="editContent.visibleImages" width="60%" :before-close="editContentHandleClose" class="dialog-visible-content">
      <upload-images :images="editContent.images" :name="editContent.imagesName" :path="editContent.imagesPath" @setImagesPath="setImagesPath" @removeImagesPath="removeImagesPath"/>
      <span slot="footer">
        <el-button type="primary" @click="editContentOrImagesSubmit">确 定</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { GetColumns } from '@/api/columns'
import { GetTagsTotal } from '@/api/tags'
import { GetList, SetInsert, SetUpdate, SetDelete, GetMessage, GetViews, content, setClick, setState, GetTags } from '@/api/messages'
import UploadImage from '@/components/UploadImage'
import UploadImages from '@/components/UploadImages'
import TinyMceEditor from '@/components/TinyMceEditor'
import Markdown from '@/components/Markdown'
import { secondToTime, millisecondToSecond, secondToMillisecond } from '@/utils/time'

export default {
  components: {
    UploadImage,
    UploadImages,
    TinyMceEditor,
    Markdown
  },
  filters: {
    typeFilter(index) {
      var indexArr = ['否', '是']
      return indexArr[index]
    },
    typeTypeFilter(index) {
      var indexTypeArr = ['warning', 'success']
      return indexTypeArr[index]
    },
    timeFilter(second) {
      return secondToTime(second)
    }
  },
  data() {
    return {
      imageUrl: '',
      image: '',
      imageName: 'messages',
      imagePath: 'messages',
      where: { 'page': 1, 'limit': 6, 'columns_id' : '', 'index' : '',  'hot' : '', 'release' : ''  },
      list: null,
      count: 0,
      listLoading: true,
      dialogTitle: '添加',
      dialogVisible: false,
      dialogType: 'insert',
      renderType: true,
      editInfo: { 'id': 0, 'name': '', 'columns_id': '', 'tags_id': '0', 'image': '', 'writer': '', 'click': '', 'weight': '', 'keywords': '', 'description': '', 'index': '', 'hot': '', 'release': '' , 'update_time': '' , 'release_time': '' , 'page': '' },
      columnsList: [],
      viewsList: [],
      tagsList: [],
      editContent: {
        title: '修改文章内容',
        visibleTinyMCE: false,
        visibleMarkdown: false,
        visibleImages: false,
        imagesName: 'messagesimages',
        imagesPath: 'messagesimages',
        contentImageName: 'messagescontent',
        contentImagePath: 'messagescontent',
        images: [],
        content: {
          'id' : 0,
          'content' : '',
          'markdown' : '',
          'images' : [],
          'type': 0
        }
      }
    }
  },
  created() {
    this.imageUrl = process.env.VUE_APP_BASE_URL
    this.getColumns()
    this.getViews()
    this.getTagsTotal()
    this.fetchData()
  },
  methods: {
    editImagesDialog(id, name) {
      // 添加图片集
      var that = this
      this.getContent(id, function(data) {
        that.editContent.title = '【' + name + '】图片集添加/修改'
        that.editContent.visibleImages = true
      })
    },
    removeImagesPath(path) {
      // 图片集删除路径
      var that = this
      for(let index in that.editContent.images){
        if(that.editContent.images[index].url === path){
          that.editContent.images.splice(index, 1)
        }
      }
      path = path.replace(that.imageUrl, "")
      for(let index in that.editContent.content.images){
        if(that.editContent.content.images[index] === path){
          that.editContent.content.images.splice(index, 1)
        }
      }
    },
    setImagesPath(imagesPath) {
      // 图片集上传成功的路径
      this.editContent.images.push({name:imagesPath.name, url: this.imageUrl + imagesPath.path})
      this.editContent.content.images.push(imagesPath.path)
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
      // 获取信息内容和图片集
      var that = this
      that.editContent.content.id = id
      that.editContent.content.type = 1
      that.editContent.content.markdown = ''
      that.editContent.content.images = []
      that.editContent.images = []
      that.editContent.content.content = ''
      content(that.editContent.content).then(res=>{
          that.editContent.content.type = 0
          that.editContent.content.markdown = res.data.markdown
          if(res.data.images !== null && res.data.images.length > 0){
            that.editContent.content.images = res.data.images.split(',')
            for(let index in that.editContent.content.images){
              let imageName = that.editContent.content.images[index].split('/')
              that.editContent.images.push({name:imageName[imageName.length - 1], url: that.imageUrl + that.editContent.content.images[index]})
            }
          }
          that.editContent.content.content = res.data.content
          callback(res.data)
      }).catch(err=>{
          that.$message({ type: 'error', message: err || '获取失败' })    
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
      // 提交修改文章内容/图片集
      var that = this
      that.editContent.content.type = 0
      that.editContent.content.images = that.editContent.content.images.toString(',')
      content(that.editContent.content).then(res=>{
          that.$message({ type: 'success', message: res.msg || '添加成功' })
      }).catch(err=>{
          that.$message({ type: 'error', message: err || '保存失败' })    
      })
    },
    getTagsTotal() {
      // 标签列表获取
      var that = this
      GetTagsTotal().then(res=>{
        that.tagsList = res.data
      }).catch(err=>[
          that.$message({ type: 'error', message: err })
      ])
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
    setWhere() {
      // 条件筛选
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
      // 删除信息
      var that = this
      var message = that.list[index]
      that.$confirm('您要永久删除【'+ message.name +'】信息吗?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          SetDelete({id: message.id}).then(res=>{
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
      // 添加信息
      this.dialogTitle = '添加信息'
      this.editInfo.id = 0
      this.editInfo.name = ''
      this.editInfo.columns_id = ''
      this.editInfo.tags_id = ''
      this.editInfo.image = ''
      this.image = ''
      this.editInfo.writer = ''
      this.editInfo.click = ''
      this.editInfo.weight = ''
      this.editInfo.keywords = ''
      this.editInfo.description = ''
      this.editInfo.index = '1'
      this.editInfo.hot = '1'
      this.editInfo.release = '1'
      this.editInfo.update_time = new Date().getTime()
      this.editInfo.release_time = new Date().getTime()
      this.editInfo.page = ''
      this.dialogType = 'insert'
      this.dialogVisible = true
    },
    editDialog(index) {
      // 修改信息
      var that = this
      var message = that.list[index]
      GetTags({id: message.id}).then(res=>{
        that.editInfo.tags_id = []
        for(let index in res.data){
          that.editInfo.tags_id.push(res.data[index].tid)
        }
        that.editInfo.id = message.id
        that.editInfo.name = message.name
        that.editInfo.columns_id = message.columns_id
        that.editInfo.image = message.image
        if(message.image.length > 0){
          that.image = that.imageUrl + message.image
        }
        that.editInfo.writer = message.writer
        that.editInfo.click = message.click
        that.editInfo.weight = message.weight
        that.editInfo.keywords = message.keywords
        that.editInfo.description = message.description
        that.editInfo.index = message.index.toString()
        that.editInfo.hot = message.hot.toString()
        that.editInfo.release = message.release.toString()
        that.editInfo.update_time = secondToMillisecond(message.update_time)
        that.editInfo.release_time = secondToMillisecond(message.release_time)
        that.editInfo.page = message.page.toString()
        that.dialogTitle = '修改【' + message.name + '】信息'
        that.dialogType = 'update'
        that.dialogVisible = true
      }).catch(err=>{
          that.$message({ type: 'error', message: err })
      })
    },
    dialogSubmit() {
      var that = this
      if(that.editInfo.tags_id.length > 0){
        that.editInfo.tags_id = that.editInfo.tags_id.toString(',')
      }else{
        that.editInfo.tags_id = ''
      }
      that.editInfo.update_time = millisecondToSecond(that.editInfo.update_time)
      that.editInfo.release_time = millisecondToSecond(that.editInfo.release_time)
      if(that.dialogType === 'update'){
        // 修改栏目 确定        
        SetUpdate(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '修改成功' })
          that.dialogVisible = false
          that.fetchData()
        }).catch(err=>{
          that.editInfo.update_time = secondToMillisecond(that.editInfo.update_time)
          that.editInfo.release_time = secondToMillisecond(that.editInfo.release_time)
          if(that.editInfo.tags_id.length > 0){
            that.editInfo.tags_id = that.editInfo.tags_id.split(',')
          }
          that.$message({ type: 'error', message: err })
        })
      }else{
        // 添加栏目 确定
        SetInsert(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '添加成功' })
          that.dialogVisible = false
          that.fetchData()
        }).catch(err=>{
          that.editInfo.update_time = secondToMillisecond(that.editInfo.update_time)
          that.editInfo.release_time = secondToMillisecond(that.editInfo.release_time)
          if(that.editInfo.tags_id.length > 0){
            that.editInfo.tags_id = that.editInfo.tags_id.split(',')
          }
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
