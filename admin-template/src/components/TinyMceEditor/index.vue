<template>
    <div class="tinymce-editor">
        <editor v-model="myValue" :init="init" @onBlur="setContent" @onClick="setContent"></editor>
    </div>
</template>
<script>
import tinymce from 'tinymce/tinymce'
import Editor from '@tinymce/tinymce-vue'
import 'tinymce/themes/silver/theme'
import 'tinymce/icons/default/icons.min.js'
import 'tinymce/plugins/image'
import 'tinymce/plugins/link'
import 'tinymce/plugins/table'
import 'tinymce/plugins/lists'
import 'tinymce/plugins/contextmenu'
import 'tinymce/plugins/wordcount'
import 'tinymce/plugins/colorpicker'
import 'tinymce/plugins/textcolor'
import 'tinymce/plugins/media'
import 'tinymce/plugins/advlist'
import 'tinymce/plugins/anchor'
import 'tinymce/plugins/autolink'
import 'tinymce/plugins/autoresize'
import 'tinymce/plugins/bbcode'
import 'tinymce/plugins/charmap'
import 'tinymce/plugins/codesample'
import 'tinymce/plugins/colorpicker'
import 'tinymce/plugins/directionality'
import 'tinymce/plugins/fullpage'
import 'tinymce/plugins/fullscreen'
import 'tinymce/plugins/help'
import 'tinymce/plugins/hr'
import 'tinymce/plugins/insertdatetime'
import 'tinymce/plugins/nonbreaking'
import 'tinymce/plugins/autosave'
import 'tinymce/plugins/code'
import 'tinymce/plugins/emoticons'
import 'tinymce/plugins/imagetools'
import 'tinymce/plugins/noneditable'
import 'tinymce/plugins/pagebreak'
import 'tinymce/plugins/paste'
import 'tinymce/plugins/preview'
import 'tinymce/plugins/print'
import 'tinymce/plugins/save'
import 'tinymce/plugins/searchreplace'
import 'tinymce/plugins/spellchecker'
import 'tinymce/plugins/tabfocus'
import 'tinymce/plugins/template'
import 'tinymce/plugins/textpattern'
import 'tinymce/plugins/visualblocks'
import 'tinymce/plugins/visualchars'
import 'tinymce/plugins/emoticons/js/emojis.min.js'
import plugins from './plugins'
import toolbar from './toolbar'
import { upload } from '@/api/public'

export default {
    components: {
        Editor
    },
    props: {
        //传入一个content，使组件支持v-model绑定
        content: {
            type: String,
            default: ''
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
            imageBase: null,
            disabled: false,
            //初始化配置
            init: {
                language_url: '/tinymce/langs/zh_CN.js',
                language: 'zh_CN',
                height: 300,
                skin_url: '/tinymce/skins/ui/oxide',
                content_css: '/tinymce/skins/content/default/content.css',
                plugins: plugins,
                toolbar: toolbar,
                branding: false,
                menubar: true,
                images_upload_handler: (blobInfo, success, failure) => {
                    var formData = new FormData()
                    var that = this
                    formData.append(that.name, blobInfo.blob(), blobInfo.filename())
                    formData.append('name', that.name)
                    formData.append('path', that.path)
                    upload(formData).then(res=>{
                        success(that.imageBase + res.data.path)
                    }).catch(res=>{
                        console.log(res)
                    })
                }
            },
            myValue: this.content
        }
    },
    mounted() {
        this.imageBase = process.env.VUE_APP_BASE_URL
        tinymce.init({})
    },
    methods: {
        setContent(e) {
            this.$emit('setContent', e, tinymce)
        },
        clear() {
            this.myValue = ''
        }
    },
    watch: {
        content(newValue) {
            this.myValue = newValue
        },
        myValue(newValue) {
            this.$emit('input', newValue)
        }
    }
}
</script>

