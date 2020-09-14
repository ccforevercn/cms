<template>
  <el-row>
    <el-row :gutter="24" class="index-cache">
      <el-col :xs="{span: 16, offset: 6}" :sm="{span: 14, offset: 8}" :md="{span: 12, offset: 10}" :lg="{span: 6, offset: 16}" :xl="{span: 6, offset: 16}">
        <el-tag>PC端</el-tag>
        <el-button-group>
          <el-button type="primary" plain size="small" @click="cacheIndexPC">缓存首页</el-button>
          <el-button type="primary" plain size="small" @click="cacheSearchPC">缓存搜索页</el-button>
        </el-button-group>
      </el-col>
      <el-col :xs="{span: 16, offset: 6}" :sm="{span: 14, offset: 8}" :md="{span: 12, offset: 10}" :lg="{span: 6, offset: 16}" :xl="{span: 6, offset: 16}">
        <el-tag type="success">WAP端</el-tag>
        <el-button-group>
          <el-button type="success" plain size="small" @click="cacheIndexWAP">缓存首页</el-button>
          <el-button type="success" plain size="small" @click="cacheSearchWAP">缓存搜索页</el-button>
        </el-button-group>
      </el-col>
    </el-row>
    <el-row :gutter="24" class="column-cache">
      <el-col :xs="{span: 20, offset: 4}" :sm="{span: 16, offset: 8}" :md="{span: 14, offset: 8}" :lg="{span: 10, offset: 8}" :xl="{span: 8, offset: 8}">
        <el-form>
          <el-form-item label="栏目缓存">
            <el-select v-model="columnId" filterable placeholder="请选择缓存的栏目">
              <el-option label="全部栏目" value="0" />
              <el-option v-for="item in columnsList" :key="item.id" :label="item.name" :value="item.id" />
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button-group>
              <el-button type="primary" @click="cacheColumnsPC">开始缓存(PC)</el-button>
              <el-button type="success" @click="cacheColumnsWAP">开始缓存(WAP)</el-button>
            </el-button-group>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
    <el-row :gutter="24" class="message-cache">
      <el-col :xs="{span: 20, offset: 4}" :sm="{span: 16, offset: 8}" :md="{span: 14, offset: 8}" :lg="{span: 10, offset: 8}" :xl="{span: 8, offset: 8}">
        <el-form>
          <el-form-item label="信息缓存">
            <el-select v-model="messageColumnId" filterable placeholder="请选择缓存的栏目">
              <el-option label="全部栏目" value="0" />
              <el-option v-for="item in columnsList" :key="item.id" :label="item.name" :value="item.id" />
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button-group>
              <el-button type="primary" @click="cacheMessagePC">开始缓存(PC)</el-button>
              <el-button type="success" @click="cacheMessageWAP">开始缓存(WAP)</el-button>
            </el-button-group>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </el-row>
</template>

<script>
import { GetColumns } from '@/api/columns'
import { index, columns, message, search } from '@/api/cache'

export default {
  data() {
    return {
      columnsList: [],
      columnId: '0',
      messageColumnId: '0',
      data: {
        url: '/',
        source: 'pc',
        id: 0
      }
    }
  },
  created() {
    this.getColumns()
  },
  methods: {
    getColumns() {
      // 栏目列表(全部)获取
      var that = this
      GetColumns().then(res => {
        that.columnsList = res.data
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    cacheIndexPC() {
      // 缓存首页 PC
      this.data.url = '/'
      this.data.source = 'pc'
      this.cacheIndex()
    },
    cacheIndexWAP() {
      // 缓存首页 WAP
      this.data.url = '/wap/'
      this.data.source = 'wap'
      this.cacheIndex()
    },
    cacheIndex() {
      // 缓存首页
      var that = this
      index(that.data).then(res => {
        const message = that.formatMessage(res.data)
        that.$alert(message, '缓存成功', { dangerouslyUseHTMLString: true })
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    cacheColumnsPC() {
      // 缓存栏目 PC
      this.data.url = '/'
      this.data.source = 'pc'
      this.cacheColumns()
    },
    cacheColumnsWAP() {
      // 缓存栏目 WAP
      this.data.url = '/wap/'
      this.data.source = 'wap'
      this.cacheColumns()
    },
    cacheColumns() {
      // 缓存栏目
      var that = this
      columns(that.data).then(res => {
        const message = that.formatMessage(res.data)
        that.$alert(message, '缓存成功', { dangerouslyUseHTMLString: true })
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    cacheMessagePC() {
      // 缓存信息 PC
      this.data.url = '/'
      this.data.source = 'pc'
      this.cacheMessage()
    },
    cacheMessageWAP() {
      // 缓存信息 WAP
      this.data.url = '/wap/'
      this.data.source = 'wap'
      this.cacheMessage()
    },
    cacheSearchPC() {
      // 缓存搜索页 PC
      this.data.url = '/'
      this.data.source = 'pc'
      this.cacheSearch()
    },
    cacheSearchWAP() {
      // 缓存搜索页 WAP
      this.data.url = '/wap/'
      this.data.source = 'wap'
      this.cacheSearch()
    },
    cacheSearch() {
      // 缓存搜索页
      var that = this
      search(that.data).then(res => {
        const message = that.formatMessage(res.data)
        that.$alert(message, '缓存成功', { dangerouslyUseHTMLString: true })
      }).catch(err => {
        that.$message({ type: 'error', message: err })
      })
    },
    cacheMessage() {
      // 缓存信息
      var that = this
      message(that.data).then(res => {
        const message = that.formatMessage(res.data)
        that.$alert(message, '缓存成功', { dangerouslyUseHTMLString: true })
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
.index-cache{
  text-align: right;
  margin-top: 10px;
}
.column-cache{
  margin: 20px 0;
}
.message-cache{
  margin: 20px 0;
}
</style>
