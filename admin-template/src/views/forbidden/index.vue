<template>
  <el-row :gutter="24">
    <el-col class="forbidden-refres" :xs="{span: 16, offset: 6}" :sm="{span: 14, offset: 8}" :md="{span: 12, offset: 10}" :lg="{span: 6, offset: 16}" :xl="{span: 6, offset: 16}">
      <el-button type="primary" plain size="small" @click="getContent">获取违禁词内容</el-button>
    </el-col>
    <el-col class="forbidden-content" :xs="{span: 16, offset: 4}" :sm="{span: 16, offset: 4}" :md="{span: 16, offset: 4}" :lg="{span: 16, offset: 4}" :xl="{span: 16, offset: 4}">
      <el-form>
        <el-input v-model="content" type="textarea" :rows="10" placeholder="违禁词内容" />
        <el-form-item class="bottom">
          <el-button-group>
            <el-button type="primary" @click="update">保存违禁词内容</el-button>
            <el-button type="success" @click="check">验证违禁词</el-button>
          </el-button-group>
        </el-form-item>
      </el-form>
    </el-col>
  </el-row>

</template>
<script>
import { GETContent, SetUpdate, checkContent } from '@/api/forbidden'

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
      // 违禁词内容获取
      var that = this
      GETContent().then(res => {
        that.content = res.data.content
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    update() {
      // 违禁词内容修改
      var that = this
      SetUpdate({ content: that.content }).then(res => {
        that.$message({ type: 'success', message: res.msg })
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    check() {
      // 验证违禁词
      var that = this
      checkContent().then(res => {
        const message = that.formatMessage(res.data)
        that.$alert(message, '违禁词列表', { dangerouslyUseHTMLString: true })
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    formatMessage(data) {
      let message = ''
      for (const index in data) {
        message += '<p>' + data[index] + '</p>'
      }
      return message
    }
  }
}
</script>

<style>
.forbidden-refres{
  text-align: right;
  margin-top: 10px;
}
.forbidden-content{
  text-align: left;
  margin-top: 40px;
}
.forbidden-content .bottom{
  text-align: center;
  margin-top: 20px;
}
</style>
