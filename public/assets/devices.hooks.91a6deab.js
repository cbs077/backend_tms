var C=Object.defineProperty,B=Object.defineProperties;var A=Object.getOwnPropertyDescriptors;var l=Object.getOwnPropertySymbols;var o=Object.prototype.hasOwnProperty,c=Object.prototype.propertyIsEnumerable;var i=(u,a,r)=>a in u?C(u,a,{enumerable:!0,configurable:!0,writable:!0,value:r}):u[a]=r,s=(u,a)=>{for(var r in a||(a={}))o.call(a,r)&&i(u,r,a[r]);if(l)for(var r of l(a))c.call(a,r)&&i(u,r,a[r]);return u},t=(u,a)=>B(u,A(a));import{d as D}from"./filter.030cb9fd.js";import{l as d}from"./vendor.9d37dd73.js";const _=()=>{const u=d([]);return{registrationHeaders:[{key:"van",value:"VAN\uC0AC\uBA85",align:"center"},{key:"modelCode",value:"\uB2E8\uB9D0\uAE30 \uBAA8\uB378 \uCF54\uB4DC",align:"center"},{key:"modelName",value:"\uB2E8\uB9D0\uAE30 \uBAA8\uB378 \uCF54\uB4DC",align:"center"},{key:"deviceNumber",value:"\uB2E8\uB9D0\uAE30 \uBC88\uD638",align:"center"},{key:"swGroupCode",value:"S/W Group \uCF54\uB4DC",align:"center"},{key:"swGroupNm",value:"S/W Group \uBA85",align:"center"},{key:"swVersion",value:"S/W Version",align:"center"},{key:"status",value:"\uC0C1\uD0DC",align:"center"},{key:"description",value:"\uC0C1\uD0DC",align:"center"},{key:"applicationDate",value:"\uB4F1\uB85D\uC77C",align:"center"},{key:"lastAccessDate",value:"\uCD5C\uC885 \uC811\uC18D\uC77C",align:"center"}],registrationHeaders_a:[{key:"modelCode",value:"\uB2E8\uB9D0\uAE30 \uBAA8\uB378 \uCF54\uB4DC",align:"center"},{key:"deviceNumber",value:"\uB2E8\uB9D0\uAE30 \uBC88\uD638",align:"center"},{key:"swGroupCode",value:"S/W Group \uCF54\uB4DC",align:"center"},{key:"swVersion",value:"S/W Version",align:"center"},{key:"status",value:"\uC0C1\uD0DC",align:"center"},{key:"applicationDate",value:"\uB4F1\uB85D\uC77C",align:"center"},{key:"lastAccessDate",value:"\uCD5C\uC885 \uC811\uC18D\uC77C",align:"center"}],logHeaders:[{key:"van",value:"VAN\uC0AC\uBA85",align:"center"},{key:"modelName",value:"\uB2E8\uB9D0\uAE30 \uBAA8\uB378\uBA85",align:"center"},{key:"deviceNumberFrom",value:"\uB2E8\uB9D0\uAE30 \uBC88\uD638 (From)",align:"center"},{key:"deviceNumberTo",value:"\uB2E8\uB9D0\uAE30 \uBC88\uD638 (To)",align:"center"},{key:"applicationDate",value:"\uB4F1\uB85D\uC77C",align:"center"},{key:"applicationUser",value:"\uB4F1\uB85D\uC790",align:"center"}],devices:u,update:e=>{u.length=30,u.push(...e.map(n=>t(s({},n),{applicationDate:D(n.applicationDate),lastAccessDate:D(n.lastAccessDate)})))},renmeObjectKey:e=>({deviceNumberFrom:e.SERIAL_NO_FROM,deviceNumberTo:e.SERIAL_NO_TO,modelName:e.CAT_MODEL_NM,swVersion:e.SW_VERSION,swOldVersion:e.OLD_SW_VERSION,swFileNm:e.UPLOAD_FILE_NM,swFileSize:e.DATA_SIZE,description:e.DESCRIPTION,applicationDate:e.REG_DT,deviceNumber:e.CAT_SERIAL_NO,lastAccessDate:e.UPDATE_DT,modelCode:e.CAT_MODEL_ID,status:e.STATUS,swGroupCode:e.SW_GROUP_ID,swGroupNm:e.SW_GROUP_NM,vanCode:e.VAN_ID,van:e.VAN_NM,applicationUser:"SK TMS",deviceCount:10,init:3,running:8,idle:10,swDownload:20,address:e.ADDR1,contact:e.PHONE,manager:e.MANAGER_NM,regDt:e.REG_DT,regUser:e.REG_USER,userId:e.USER_ID,userNm:e.USER_NM,squad:e.USER_RIGHTS_NM,request:e.GUBUN})}};export{_ as u};