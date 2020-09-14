<template>
  <div class="dashboard-container dashboard">
    <div class="top">欢迎管理员： {{ admin.real_name }} 当前时间:{{ time }}</div>
    <div ref="echarts" class="echarts" />
  </div>
</template>

<script>

import { mapGetters } from 'vuex'
import { statistics as GetMessagesStatistics } from '@/api/messages'
import { statistics as GetChatsStatistics } from '@/api/chats'
import echarts from 'echarts/lib/echarts'
import 'echarts/lib/chart/line'
import 'echarts/lib/component/tooltip'
import 'echarts/lib/component/title'
import 'echarts/lib/component/dataZoom'
import 'echarts/lib/component/legendScroll'
import { secondToTime } from '@/utils/time'

export default {
  name: 'Dashboard',
  data() {
    return {
      xAxisData: [],
      titleText: '',
      series: [],
      legendData: [],
      status: false,
      time: 0,
      timer: 0
    }
  },
  computed: {
    ...mapGetters([
      'admin'
    ])
  },
  mounted() {
    this.getMessageStatistics()
    this.getChatsStatistics()
    this.time = secondToTime(Math.round(new Date().getTime() / 1000))
    this.setTime()
  },
  destroyed() {
    clearInterval(this.timer)
  },
  methods: {
    setTime() {
      var that = this
      that.timer = setInterval(function() {
        that.time = secondToTime(Math.round(new Date().getTime() / 1000))
      }, 1000)
    },
    setChart() {
      var that = this
      that.titleText = that.titleText.substring(0, that.titleText.length - 1) + '统计'
      var chart = echarts.init(this.$refs.echarts)
      chart.setOption({
        title: { left: 'left', text: that.titleText },
        tooltip: {
          show: true,
          orient: 'horizontal',
          showTitle: true,
          trigger: 'axis',
          axisPointer: {
            type: 'cross',
            label: { backgroundColor: '#6a7985' }
          }
        },
        xAxis: { type: 'category', boundaryGap: false, data: that.xAxisData },
        legend: { data: that.legendData },
        grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
        yAxis: [{ type: 'value', boundaryGap: [0, '100%'] }],
        dataZoom: [{ start: 50, type: 'inside' }, { type: 'slider', show: true, start: 50 }],
        series: that.series
      })
    },
    getChatsStatistics() {
      var that = this
      GetChatsStatistics().then(res => {
        that.legendData.push(res.msg)
        that.series.push(that.formatSeries(res.msg, res.data))
        if (that.status) {
          that.setChart()
        } else {
          that.status = true
        }
      }).catch(err => {
        that.$message({ type: 'error', message: err || '获取失败' })
      })
    },
    getMessageStatistics() {
      // 获取信息发布
      var that = this
      GetMessagesStatistics().then(res => {
        that.legendData.push(res.msg)
        that.series.push(that.formatSeries(res.msg, res.data))
        if (that.status) {
          that.setChart()
        } else {
          that.status = true
        }
      }).catch(err => {
        that.$message({ type: 'error', message: err || '获取失败' })
      })
    },
    formatSeries(msg, data) {
      // 格式化series
      var that = this
      const xAxisDataLength = that.xAxisData.length
      let series
      // eslint-disable-next-line prefer-const
      series = {
        'name': msg,
        'type': 'line',
        'data': []
      }
      that.titleText += msg + '和'
      for (const index in data) {
        series.data.push(data[index].count)
        if (xAxisDataLength === 0) {
          that.xAxisData.push(data[index].week)
        }
      }
      return series
    }
  }
}
</script>

<style lang="scss" scoped>
.dashboard {
  height: 800px;
  .top{
    height: 100px;
    text-align: center;
    line-height: 100px;
    color: #666fff;
  }
  .echarts{
    height: 700px;
  }
  &-container {
    margin: 30px;
  }
  &-text {
    font-size: 30px;
    line-height: 46px;
  }
}
</style>
