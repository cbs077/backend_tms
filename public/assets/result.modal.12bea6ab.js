import{B as i}from"./base-modal.2684ffef.js";import{_ as c}from"./index.d29c9db7.js";import{d as _,j as f,e as o,o as b,b as B,w as r,a as C,f as l}from"./vendor.9d37dd73.js";const V=_({components:{BaseModal:i},props:{title:{type:String,required:!0,default:""},modelValue:{type:Boolean,required:!1,default:!0},items:{type:Array,required:!0,default:()=>[]}},emits:["update:modelValue"],setup(e,{emit:t}){const a=f({get:()=>e.modelValue,set:s=>{t("update:modelValue",s)}});return{header:[{key:"deviceNumber",value:"\uB2E8\uB9D0\uAE30 \uBC88\uD638"},{key:"status",value:"\uC0C1\uD0DC"}],isOpen:a,closeModal(){a.value=!1}}}}),v={class:"rounded border border-sk-gray"};function y(e,t,a,d,s,D){const u=o("el-table-column"),n=o("el-table"),p=o("base-modal");return b(),B(p,{modelValue:e.isOpen,"onUpdate:modelValue":t[0]||(t[0]=m=>e.isOpen=m),class:"w-2/3",title:e.title,"no-action":""},{modalBody:r(()=>[C("div",v,[l(n,{data:e.items,fit:"",class:"rounded"},{default:r(()=>[l(u,{prop:"deviceNumber",label:"\uB2E8\uB9D0\uAE30\uBC88\uD638",align:"center"}),l(u,{prop:"status",label:"\uC0C1\uD0DC",align:"center"})]),_:1},8,["data"])])]),_:1},8,["modelValue","title"])}var N=c(V,[["render",y]]);export{N as R};