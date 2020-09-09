<template>
    <el-upload
        class="images-uploader"
        :action="action"
        :headers="headers"
        :data="data"
        :name="name"
        :show-file-list="false"
        :on-success="handleSuccess"
        :on-error="handleError"
        :on-exceed="handleExceed"
        >
        <img v-if="status" :src="images" class="images">
        <i v-else class="el-icon-plus images-uploader-icon"></i>
    </el-upload>
</template>
<script>
import { getToken } from '@/utils/auth'

export default {
    // 单图片上传组件
    name: 'UploadImage',
    props: {
        images: {
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
    data() {
        return {
            status: false,
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
    watch: {
        images: {
            handler(newValue, oldValue){
                this.images = newValue
            },
                deep:true
            }
        },
    created() {
        var that = this
        that.action = process.env.VUE_APP_BASE_API + '/uploads/upload'
        that.data.name = that.name 
        that.data.path = that.path
        if(that.images.length > 0){
            that.status = true
        }
    },
    methods:{
        handleSuccess(response, file, fileList) {
            // 文件上传成功
            var that = this;
            if(response.code == 200){
                that.status = false
                that.$emit('setImagePath',response.data)
                that.status = true
                return that.$message({ type: 'success', message: '文件上传成功' })
            }else{
                return that.$message({ type: 'error', message: response.msg || '文件上传失败' })
            }
        },
        handleError(err, file, fileList) {
            // 文件上传失败
            return that.$message({ message: err || '文件上传失败' })
        },
        handleExceed(files, fileList) {
            // 文件超出个数限制
            return that.$message({ type: 'error', message: '文件超出个数限制' })
        },
    }
}
</script>
<style>
    .images-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .images-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .images-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .images {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>