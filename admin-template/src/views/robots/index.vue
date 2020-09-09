<template>
  <el-row :gutter="24">
    <el-col class="robots-refres" :xs="{span: 16, offset: 6}" :sm="{span: 14, offset: 8}" :md="{span: 12, offset: 10}" :lg="{span: 6, offset: 16}" :xl="{span: 6, offset: 16}">
      <el-button type="primary" plain size="small" @click="getContent">获取robots内容</el-button>
    </el-col>
    <el-col  class="robots-content" :xs="{span: 16, offset: 4}" :sm="{span: 16, offset: 4}" :md="{span: 16, offset: 4}" :lg="{span: 16, offset: 4}" :xl="{span: 16, offset: 4}">
    <el-form>
      <el-input type="textarea" :rows="10" placeholder="robots内容" v-model="content"></el-input>
        <el-form-item class="bottom"><el-button type="primary" @click="update">保存robots内容</el-button></el-form-item>
    </el-form>
    </el-col>
  </el-row>
  
</template>
<script>
import { GETContent, SetUpdate } from '@/api/robots'

export default {
  data() {
    return {
      content: ''
    }
  },
  created() {
    this.getContent()
  },
  methods: {
    getContent() {
      // robots内容获取
      var that = this
      GETContent().then(res=>{
        that.content = res.data.content
      }).catch(err=>{
          that.$message({ type: 'error', message: err })
      })
    },
    update() {
      // robots内容修改
      var that = this
      SetUpdate({content: that.content}).then(res=>{
          that.$message({ type: 'success', message: res.msg })
      }).catch(err=>{
          that.$message({ type: 'error', message: err })
      })
    }
  }
}
</script>

<style>
.robots-refres{
  text-align: right;
  margin-top: 10px;
}
.robots-content{
  text-align: left;
  margin-top: 40px;
}
.robots-content .bottom{
  text-align: center;
  margin-top: 20px;
}
</style>
