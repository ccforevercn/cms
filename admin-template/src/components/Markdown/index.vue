<template>
    <mavon-editor ref="mavon" v-model="content" :toolbars="markdownOption" :ishljs = "ishljs" @change="setContent" @save="setContent" @fullScreen="fullScreen" @readModel="readModel" @htmlCode	="htmlCode" @subfieldToggle="subfieldToggle" @previewToggle="previewToggle" @helpToggle="helpToggle" @navigationToggle="navigationToggle" @imgAdd="imgAdd" @imgDel="imgDel"/>
</template>
<script>
import { getToken } from '@/utils/auth'
import { upload } from '@/api/public'

export default {
    // 单图片上传组件
    name: 'Markdown',
    // props: ['contentMarkdown'], 
    props : {
        contentMarkdown: {
            type: String,
            required: true
        },
        name: {
            type: String,
            required: true
        },
        path: {
            type: String,
            required: true
        }
    },
    watch: {
        contentMarkdown (value) {
            this.content = value
        }
    },
    data() {
        return {
            content: '',
            ishljs: true,
            markdownOption: {
                bold: true, // 粗体
                italic: true, // 斜体
                header: true, // 标题
                underline: true, // 下划线
                strikethrough: true, // 中划线
                mark: true, // 标记
                superscript: true, // 上角标
                subscript: true, // 下角标
                quote: true, // 引用
                ol: true, // 有序列表
                ul: true, // 无序列表
                link: true, // 链接
                imagelink: true, // 图片链接
                code: true, // code
                table: true, // 表格
                fullscreen: true, // 全屏编辑
                readmodel: true, // 沉浸式阅读
                htmlcode: true, // 展示html源码
                help: true, // 帮助
                /* 1.3.5 */
                undo: true, // 上一步
                redo: true, // 下一步
                trash: true, // 清空
                save: true, // 保存（触发events中的save事件）
                /* 1.4.2 */
                navigation: true, // 导航目录
                /* 2.1.8 */
                alignleft: true, // 左对齐
                aligncenter: true, // 居中
                alignright: true, // 右对齐
                /* 2.2.1 */
                subfield: true, // 单双栏模式
                preview: true, // 预览
            },
            imageUrl: '',
            data: {
                'name': '',
                'path': ''
            }
        }
    },
    created() {
        this.content = this.contentMarkdown
        this.imageUrl = process.env.VUE_APP_BASE_URL
        this.data.name = this.name 
        this.data.path = this.path
    },
    methods:{
        setContent(content, render) {
            // 修改内容和保存时触发
            // 给父组件中set文本框中的content和render
            this.$emit('setContent', content, render);
        },
        fullScreen(status, value) {
            // 切换全屏编辑的回调事件
            console.log('fullScreen')
            console.log(status)
            console.log(value)
        },
        readModel(status, value) {
            // 切换沉浸式阅读的回调事件
            console.log('readModel')
            console.log(status)
            console.log(value)
        },
        htmlCode(status, value) {
            // 查看html源码的回调事件
            console.log('htmlCode')
            console.log(status)
            console.log(value)
        },
        subfieldToggle(status, value) {
            // 切换单双栏编辑的回调事件
            console.log('subfieldToggle')
            console.log(status)
            console.log(value)
        },
        previewToggle(status, value) {
            // 切换预览编辑的回调事件
            console.log('previewToggle')
            console.log(status)
            console.log(value)
        },
        helpToggle(status, value) {
            // 查看帮助的回调事件
            console.log('helpToggle')
            console.log(status)
            console.log(value)
        },
        navigationToggle(status, value) {
            // 切换导航目录的回调事件
            console.log('navigationToggle')
            console.log(status)
            console.log(value)
        },
        imgAdd(filename, imgfile) {
            // 图片文件添加回调事件
            var that = this
            var formData = new FormData()
            formData.append(that.data.name, imgfile)
            formData.append('name', that.data.name)
            formData.append('path', that.data.path)
            // 上传文件
            upload(formData).then(res=>{
                that.$refs.mavon.$img2Url(filename, this.imageUrl + res.data.path)
            }).catch(err=>{
                that.$message({ type: 'error', message: err || '上传失败' }) 
            })

        },
        imgDel(filename) {
            // 图片文件删除回调事件
            console.log('imgDel')
        },
    }
}
</script>
<style scoped>
    .mavonEditor {
        width: 100%;
        height: 100%;
    }
</style>