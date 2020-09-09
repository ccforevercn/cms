<template>
<div>
    <el-upload ref="upload" :headers="headers" :action="action" :data="data" :name="name" :file-list="images" :on-preview="handlePreview" :on-remove="handleRemove" :multiple="multiple" :on-success="handleSuccess" :on-error="handleError" :on-exceed="handleExceed" list-type="picture">
        <el-button size="small" type="primary">点击上传</el-button>
    </el-upload>
  <el-dialog width="30%" :title="imageDialog.title" :visible.sync="imageDialog.visible" append-to-body><img class="image-dialog-img" :src="imageDialog.src" :alt="imageDialog.alt"></el-dialog>
</div>
</template>
<script>
import { getToken } from '@/utils/auth'

export default {
    // 多图片上传组件
    name: 'UploadImages',
    props: {
        images: {
            type: Array,
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
    data() {
        return {
            imageDialog: {
                visible: false,
                src: '',
                alt: '',
                title: '',
            },
            multiple: true,
            action: '',
            headers: {
                'Authorization': 'bearer ' + getToken()
            },
            data: {
                'name': '',
                'path': ''
            }
        }
    },
    created() {
        this.action = process.env.VUE_APP_BASE_API + '/uploads/upload'
        this.data.name = this.name 
        this.data.path = this.path
    },
    methods:{
        handleSuccess(response, file, fileList) {
            // 文件上传成功
            var that = this
            var uploadFlieLength = that.$refs.upload.uploadFiles.length
            var timer = setInterval(function(){
                var uploadFlieForLength = 0
                for(let index in that.$refs.upload.uploadFiles){
                    if(that.$refs.upload.uploadFiles[index].status === 'success'){
                        uploadFlieForLength++
                    }
                }
                if(uploadFlieLength === uploadFlieForLength){
                    for(let index in that.$refs.upload.uploadFiles){
                        if(that.$refs.upload.uploadFiles[index].hasOwnProperty('response')){
                            that.$emit('setImagesPath', that.$refs.upload.uploadFiles[index].response.data)
                        }
                    }
                    clearInterval(timer)
                    return that.$message({ type: 'success', message: '文件上传成功' })
                }
            }, 0)
        },
        handleError(err, file, fileList) {
            // 文件上传失败
            return this.$message({ type: 'error', message: err || '文件上传失败' })
        },
        handleExceed(files, fileList) {
            // 文件超出个数限制
            return this.$message({ type: 'error', message: '文件超出个数限制' })

        },
        handleRemove(file, fileList) {
            this.$emit('removeImagesPath',file.url)
        },
        handlePreview(file) {
            // 查看图片大图
            this.imageDialog.src = file.url
            this.imageDialog.alt = file.name
            this.imageDialog.title = file.name
            this.imageDialog.visible = true
        }
    }
}
</script>
<style>
.image-dialog-img{
    width: 100%;
}
</style>