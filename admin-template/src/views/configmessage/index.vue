<template>
  <div class="app-container">
    <el-row :gutter="24">
      <el-col class="insert-button">
          <el-button-group>
              <el-button type="primary" plain size="small" @click="create">配置信息添加</el-button>
              <el-button type="success" plain size="small" @click="fetchData">刷新列表</el-button>
          </el-button-group>
      </el-col>
    </el-row>
    <el-menu :default-active="where.category_id" mode="horizontal" @select="whereCategoryId">
      <template v-for="item in category"><el-menu-item  :key="item.id" :index="'' + item.id + ''" v-text="item.name"></el-menu-item></template>
    </el-menu>
    <el-table v-loading="listLoading" :data="list" element-loading-text="Loading" border fit highlight-current-row >
      <template slot="empty">暂无配置信息</template>
      <el-table-column label="唯一值">
        <template slot-scope="scope"><span class="cursor"><el-tag type="success" effect="plain" @click="cp(labelPrefix + scope.row.select)">{{ labelPrefix + scope.row.select }}&nbsp;&nbsp;&nbsp;复制</el-tag></span></template>
      </el-table-column>
      <el-table-column label="配置名称">
        <template slot-scope="scope"><span>{{ scope.row.name }}</span></template>
      </el-table-column>
      <el-table-column label="配置值">
        <template slot-scope="scope"><span>{{ scope.row.value | formatValueFilter(scope.row.type_value, scope.row.type, that) }}</span></template>
      </el-table-column>
      <el-table-column label="配置类型">
        <template slot-scope="scope"><el-tag class="cursor" :type="scope.row.type | typeColorFilter">{{ scope.row.type| typeFilter }}</el-tag></template>
      </el-table-column>
      <el-table-column label="配置描述">
        <template slot-scope="scope">{{ scope.row.description }}</template>
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
    <el-dialog :title="dialogTitle" :visible.sync="dialogVisible" :before-close="dialogBeforeClosed" width="60%" center >
      <el-form class="edit-dialog-form">
        <el-form-item label="配置名称">
          <el-input v-model="editInfo.name"></el-input>
        </el-form-item>
        <el-form-item label="配置描述">
          <el-input v-model="editInfo.description"></el-input>
        </el-form-item>
        <el-form-item label="唯 一 值">
          <el-input v-model="editInfo.select" :readonly="editInfo.selectReadonly"></el-input>
        </el-form-item>
        <el-form-item label="配置分类">
            <el-select v-model="editInfo.category_id" placeholder="配置分类" :disabled="editInfo.categoryIdDisabled">
              <el-option v-for="item in category" :label="item.name" :value="item.id" :key="item.id"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="配置类型">
          <el-radio-group v-model="editInfo.type" :disabled="editInfo.typeDisabled" @change="setEditInfoTypeValueStatus">
            <el-radio label="1">文本框</el-radio>
            <el-radio label="2">单选按钮</el-radio>
            <el-radio label="3">多选按钮</el-radio>
            <el-radio label="4">文件上传</el-radio>
            <el-radio label="5">多行文本框</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="类 型 值" v-show="editInfoValueRadioStatus || editInfoValueCheckBoxStatus">
          <el-input v-model="editInfo.type_value" :readonly="editInfo.typeValueReadonly" placeholder="配置类型值格式：field:value|field:value..."  @change="setEditInfoRadisOrCheckBoxValue"></el-input>
        </el-form-item>
        <el-form-item label="配 置 值">
          <el-radio-group v-model="editInfo.value" v-show="editInfoValueRadioStatus">
            <el-radio :label="item[0]" v-for="item in radioOrCheckBoxValue" :key="item[0]">{{ item[1] }}</el-radio>
          </el-radio-group>
          <el-checkbox-group v-model="checkBoxValue" v-show="editInfoValueCheckBoxStatus">
            <el-checkbox :label="item[0]" v-for="item in radioOrCheckBoxValue" :key="item[0]">{{ item[1] }}</el-checkbox>
          </el-checkbox-group>
          <el-input v-show="editInfoValueInputStatus" v-model="editInfo.value"></el-input>
          <el-input type="textarea" v-show="editInfoValueTextareaStatus" v-model="editInfo.value"></el-input>
          <upload-image v-show="editInfoValueImageStatus" :images="image" :name="imageName" :path="imagePath" @setImagePath="setImagePath"/>
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
import { GetList, SetInsert, SetUpdate, SetDelete, GetMessage, GetConfig } from '@/api/configmessage'
import { GetConfigCategory } from '@/api/configcategory'
import UploadImage from '@/components/UploadImage'
import copy from 'copy-to-clipboard'

export default {
  components: {
    UploadImage
  },
  filters: {
    formatValueFilter(value, values, type, that) {
      let newValue = value
      if(type === 2){
        // 单选按钮值处理
        if(value.length > 0){
          newValue = that.formatConfigRadioOrCheckBoxvalue(values, value)
        }
      }else if(type === 3){
        // 多选按钮值处理
        if(value.length > 0){
          let valueArr = []
          newValue = ''
          valueArr = value.split('|')
          for(let index in valueArr){
            newValue += that.formatConfigRadioOrCheckBoxvalue(values, valueArr[index]) + ','
          }
          newValue = newValue.substring(0,newValue.length - 1)
        }
      }
      return newValue
    },
    typeFilter(type) {
      if(type > 5) type = 0
      var typeArr = ['未知类型', '文本框', '单选按钮', '多选按钮', '文件上传', '多行文本框']
      return typeArr[type]
    },
    typeColorFilter(type) {
      if(type > 5) type = 0
      var typeColorArr = ['danger', 'primary', 'success', 'info', 'warning', '']
      return typeColorArr[type]
    }
  },
  data() {
    return {
      that: null,
      imageUrl: '',
      image: '',
      imageName: 'config',
      imagePath: 'config',
      where: { 'page': 1, 'limit': 6, 'category_id': '' },
      list: null,
      count: 0,
      labelPrefix: '',
      listLoading: true,
      dialogTitle: '修改',
      dialogVisible: false,
      dialogType: 'insert',
      editInfo: { 
        'id': 0, 
        'name': '', 
        'description': '', 
        'select': '', 
        'selectReadonly': false, 
        'category_id': '', 
        'categoryIdDisabled' : false,
        'type': '', 
        'typeDisabled': false, 
        'type_value': '', 
        'typeValueReadonly': false, 
        'value': ''
      },
      checkBoxValue: [], /* 多选按钮值 */
      radioOrCheckBoxValue: [], /* 单选按钮和多选按钮的值 */
      editInfoValueRadioStatus: false, /* 配置类型为单选按钮 */
      editInfoValueCheckBoxStatus: false, /* 配置类型为多选按钮 */
      editInfoValueInputStatus: false, /*  配置类型为文本框 */
      editInfoValueTextareaStatus: false, /*  配置类型为多行文本框 */
      editInfoValueImageStatus: false,/*  配置类型为文件上传 */
      category: []
    }
  },
  created() {
    this.imageUrl = process.env.VUE_APP_BASE_URL
    this.getConfigLabelPrefix()
    this.getConfigCategory()
    this.that = this
  },
  methods: {
    getConfigLabelPrefix() {
      // 获取唯一值前缀
      var that = this
      GetConfig({select: 'label_prefix'}).then(res=>{
        that.labelPrefix = res.data.data
      }).catch(err=>{
        that.$message({ type: 'error', message: err })
      })
    },
    cp(content) {
      // 复制唯一值
      copy(content)
      this.$message({ type: 'success', message: '复制成功' })
    },
    setImagePath(imagePath) {
      // 图片上传成功的路径
      var that = this
      that.image = that.imageUrl + imagePath.path
      that.editInfo.value = imagePath.path
    },
    setEditInfoRadisOrCheckBoxValue() {
      // 单选按钮和多选按钮修改时触发 格式化类型值
      this.radioOrCheckBoxValue = this.formatConfigRadioOrCheckBoxvalue(this.editInfo.type_value, '')
    },
    setEditInfoTypeValueStatus() {
      // 配置类型回调，根据配置类型是否展示配置类型值和配置值
      let that = this
      let type = Number(this.editInfo.type)
      switch (type) {
        case 2:
          that.editInfoValueRadioStatus = true
          that.editInfoValueCheckBoxStatus = false
          that.editInfoValueTextareaStatus = false
          that.editInfoValueImageStatus = false
          that.editInfoValueInputStatus = false
          break
        case 3:
          that.editInfoValueRadioStatus = false
          that.editInfoValueCheckBoxStatus = true
          that.editInfoValueTextareaStatus = false
          that.editInfoValueImageStatus = false
          that.editInfoValueInputStatus = false
          break
        case 4:
          that.editInfoValueRadioStatus = false
          that.editInfoValueCheckBoxStatus = false
          that.editInfoValueInputStatus = false
          that.editInfoValueTextareaStatus = false
          that.editInfoValueImageStatus = true
          break
        case 5:
          that.editInfoValueRadioStatus = false
          that.editInfoValueCheckBoxStatus = false
          that.editInfoValueInputStatus = false
          that.editInfoValueTextareaStatus = true
          that.editInfoValueImageStatus = false
          break
        case 1: 
        default:
          that.editInfoValueRadioStatus = false
          that.editInfoValueCheckBoxStatus = false
          that.editInfoValueInputStatus = true
          that.editInfoValueTextareaStatus = false
          that.editInfoValueImageStatus = false
      }
      that.editInfo.value = ''
      that.editInfo.type_value = ''
      that.checkBoxValue = 
      that.radioOrCheckBoxValue = []
    },
    whereCategoryId(index, indexPath) {
        // 配置类型筛选
        var that = this
        that.where.category_id =index
        that.where.page =1
        that.fetchData()
    },
    getConfigCategory() {
        // 配置类型
        var that = this
        GetConfigCategory().then(res=>{
            that.category = res.data
            if(that.category.length > 0){
                that.where.category_id = that.category[0].id.toString()
                that.fetchData()
            }else{
                that.listLoading = false
            }
        }).catch(err=>{
            that.$message({ type: 'error', message: err })
            that.listLoading = false
        })
    },
    deleteDialog(index) {
      // 删除配置分类
      var that = this
      var message = that.list[index]
      that.$confirm('您要永久删除【'+ message.name +'】配置吗?', '提示', {
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
    resetEditInfo() {
       // 重置修改信息
        this.editInfo.id = 0
        this.editInfo.name = ''
        this.editInfo.description = ''
        this.editInfo.select = ''
        this.editInfo.selectReadonly = false
        this.editInfo.category_id = ''
        this.editInfo.categoryIdDisabled = false
        this.editInfo.type = '1'
        this.editInfo.typeDisabled = false
        this.editInfo.type_value = ''
        this.editInfo.typeValueReadonly = false
        this.editInfo.value = ''
        this.image = ''
        this.editInfoValueInputStatus = true
        this.editInfoValueTextareaStatus = false
        this.editInfoValueImageStatus = false
        this.editInfoValueRadioStatus = false
        this.editInfoValueCheckBoxStatus = false
        this.radioOrCheckBoxValue = []
        this.checkBoxValue = []
    },
    create() {
      // 添加配置分类
      this.resetEditInfo()
      this.dialogTitle = '添加配置'
      this.dialogType = 'insert'
      this.dialogVisible = true
    },
    formatConfigRadioOrCheckBoxvalue(values, select) {
      // 格式化单选按钮和多选按钮值
      let format = []
      let formatValue= []
        if(values.length > 0){
          values = values.split('|')
            if(values.length >= 2){
              for(let index in values){
                    formatValue = values[index].split(':')
                    console.log(select.length)
                    if(select.length > 0){
                      if(select === formatValue[0]){
                        return formatValue[1]
                      }
                    }else{
                      if(formatValue.length !== 2){
                        return format
                      }
                      format.push(formatValue)
                    }
              }
            }
        }
        return format
    },
    editDialog(index) {
      // 修改配置
      var message = this.list[index]
      this.resetEditInfo()
      this.editInfo.id = message.id
      this.editInfo.name = message.name
      this.editInfo.description = message.description
      this.editInfo.select = message.select
      this.editInfo.category_id = message.category_id
      this.editInfo.type = message.type.toString()
      this.setEditInfoTypeValueStatus()
      this.editInfo.type_value = message.type_value
      this.radioOrCheckBoxValue = this.formatConfigRadioOrCheckBoxvalue(message.type_value, '')
      this.editInfo.value = message.value
      this.checkBoxValue = this.editInfo.value.split('|')
      this.image = this.imageUrl + message.value
      this.editInfo.selectReadonly = true
      this.editInfo.categoryIdDisabled = true
      this.editInfo.typeDisabled = true
      this.editInfo.typeValueReadonly = true
      this.dialogTitle = '修改【' + message.name + '】配置(可修改配置名称，配置值，配置描述)'
      this.dialogType = 'update'
      this.dialogVisible = true
    },
    dialogSubmit() {
      var that = this
      if(Number(that.editInfo.type) === 3){
        that.editInfo.value = that.checkBoxValue.join('|')
      }
      if(that.dialogType === 'update'){
        // 修改配置确定
        SetUpdate(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '修改成功' })
          that.dialogVisible = false
          that.fetchData()
        }).catch(err=>{
          that.$message({ type: 'error', message: err })
        })
      }else{
        // 添加配置确定
        SetInsert(that.editInfo).then(res=>{
          that.$message({ type: 'success', message: res.msg || '添加成功' })
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
      // 修改配置取消
      var that = this
      that.dialogVisible = false
      var message = '取消添加配置'
      if(that.dialogType === 'update'){
        message = '取消修改配置'
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
      // 获取配置列表
      var that = this
      that.listLoading = true
      if(that.category.length > 0){
          GetList(that.where).then(response => {
            that.list = response.data.list
            that.count = response.data.count
            that.listLoading = false
          }).catch(err=>{
            that.$message({ type: 'error', message: err })
          })
      }else{
          that.listLoading = false
          that.$message({ type: 'error', message: '请先添加配置分类' })
      }
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
    .el-textarea{
      width: 80%;
    }
  }
  .insert-button{
      text-align: right;
      margin-bottom: 10px;
  }
</style>
