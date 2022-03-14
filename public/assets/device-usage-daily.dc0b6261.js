import{U as a}from"./index.e12753c8.js";import{T as h}from"./table-common-button.f5560c2d.js";import{a as R,b as F}from"./filter.030cb9fd.js";import{_ as T}from"./index.d29c9db7.js";import{d as V,l as c,e as o,o as d,c as b,f as e,a as n,w as i,F as _,k as E,b as N}from"./vendor.9d37dd73.js";const I=V({name:"DeviceRegistrationLogs",components:{TableCommonButton:h},setup(){const l=c({available:[{value:"test"}],select:void 0,query:a.lorem.word()}),u=c({all:!1,modelCode:!1,van:!1}),s=c({modal:!1}),p=C=>{s.modal=!0},m={date:R(new Date),deviceNumber:a.lorem.word(),cdmaTrade:a.datatype.number(),contactIcCardInsert:a.datatype.number(),hotlineTrade:a.datatype.number(),lineTrade:a.datatype.number(),msrReading:a.datatype.number(),printerCutting:a.datatype.number(),rfCardInsert:a.datatype.number(),van:a.name.findName(),category:a.lorem.word()};return{items:[...F(m)],filter:l,displayOptions:u,deviceUsageDetail:s,onRowClicked:p}}}),x={class:"mb-4 rounded border border-sk-gray bg-option-background p-3 pl-8"},U={class:"my-3 flex flex-row"},M=n("div",{class:"my-auto w-1/12"},"VAN\uC0AC\uBA85",-1),Y={class:"my-auto w-5/12 pr-9"},$=n("div",{class:"my-auto w-1/12"},"\uB2E8\uB9D0\uAE30 \uBC88\uD638",-1),q={class:"my-auto flex w-5/12"},z=n("div",{class:"grow"},null,-1),L={class:"rounded border border-sk-gray"},O={class:"flex justify-center"};function j(l,u,s,p,m,g){const C=o("bread-crumb"),f=o("el-option"),D=o("el-select"),v=o("el-input"),y=o("options-search-button"),B=o("excel-button"),A=o("table-common-button"),t=o("el-table-column"),w=o("el-table"),k=o("el-pagination");return d(),b(_,null,[e(C,{text:"\uC77C\uC790\uBCC4 \uB2E8\uB9D0\uAE30 \uC0AC\uC6A9\uC870\uD68C"}),n("div",x,[n("div",U,[M,n("div",Y,[e(D,{modelValue:l.filter.select,"onUpdate:modelValue":u[0]||(u[0]=r=>l.filter.select=r),clearable:"",placeholder:"\uC120\uD0DD",size:"large",class:"w-full"},{default:i(()=>[(d(!0),b(_,null,E(l.filter.available,r=>(d(),N(f,{key:r.value,label:r.value,value:r.value},null,8,["label","value"]))),128))]),_:1},8,["modelValue"])]),$,n("div",q,[e(v,{modelValue:l.filter.query,"onUpdate:modelValue":u[1]||(u[1]=r=>l.filter.query=r),size:"large"},null,8,["modelValue"])])]),e(y)]),e(A,null,{body:i(()=>[z,e(B,{class:"mr-1"})]),_:1}),n("div",L,[e(w,{data:l.items,fit:"",class:"rounded",onRowClick:l.onRowClicked},{default:i(()=>[e(t,{prop:"date",label:"\uC77C\uC790",align:"center"}),e(t,{prop:"van",label:"VAN\uC0AC",align:"center"}),e(t,{prop:"deviceNumber",label:"\uB2E8\uB9D0\uAE30 \uBC88\uD638",align:"center"}),e(t,{prop:"printerCutting",label:"\uD504\uB9B0\uD130 \uCEE4\uD305 \uD69F\uC218",align:"center"}),e(t,{prop:"msrReading",label:"MSR Reading \uD69F\uC218",align:"center"}),e(t,{prop:"contactIcCardInsert",label:"CONTACT IC CARD \uC0BD\uC785 \uD69F\uC218",align:"center"}),e(t,{prop:"rfCardInsert",label:"RF CARD \uC0BD\uC785 \uD69F\uC218",align:"center"}),e(t,{prop:"hotlineTrade",label:"\uC804\uC6A9\uC120 \uAC70\uB798 \uD69F\uC218",align:"center"}),e(t,{prop:"cdmaTrade",label:"CDMA \uAC70\uB798 \uD69F\uC218",align:"center"}),e(t,{prop:"lineTrade",label:"\uC804\uD654\uC120 \uAC70\uB798 \uD69F\uC218",align:"center"}),e(t,{prop:"category",label:"\uAD6C\uBD84",align:"center"})]),_:1},8,["data","onRowClick"])]),n("div",O,[e(k,{background:"",class:"my-6",layout:"prev, pager, next",total:1e3})])],64)}var P=T(I,[["render",j]]);export{P as default};