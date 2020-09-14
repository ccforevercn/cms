<template>
  <el-row :gutter="24">
    <el-col class="robots-content" :xs="{span: 18, offset: 2}" :sm="{span: 18, offset: 2}" :md="{span: 18, offset: 2}" :lg="{span: 18, offset: 2}" :xl="{span: 18, offset: 2}">
      <el-form>
        <el-input v-model="urls" type="textarea" :rows="10" placeholder="网站链接" />
        <el-form-item class="bottom"><el-button type="primary" @click="setHtml">网站地图html缓存</el-button></el-form-item>
        <el-form-item class="bottom"><el-button type="primary" @click="setXml">网站地图xml缓存</el-button></el-form-item>
        <el-form-item class="bottom"><el-button type="primary" @click="setTxt">网站地图txt缓存</el-button></el-form-item>
      </el-form>
    </el-col>
  </el-row>

</template>
<script>
import { GetIndex, SetHtml, SetXml, SetTxt } from '@/api/sitemap'

export default {
  data() {
    return {
      urls: ''
    }
  },
  created() {
    this.getUrls()
  },
  methods: {
    getUrls() {
      // 网站链接获取
      var that = this
      GetIndex().then(res => {
        that.urls = res.data.join('\r\n')
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    setHtml() {
      // 网站地图html缓存
      var that = this
      SetHtml().then(res => {
        that.$message({ type: 'success', message: res.msg })
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    setXml() {
      // 网站地图xml缓存
      var that = this
      SetXml().then(res => {
        that.$message({ type: 'success', message: res.msg })
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    setTxt() {
      // 网站地图txt缓存
      var that = this
      SetTxt().then(res => {
        that.$message({ type: 'success', message: res.msg })
      }).catch(err => {
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
