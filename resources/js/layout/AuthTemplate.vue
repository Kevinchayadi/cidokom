<template>
    <div :class="[templatestyle, backgroundstyle]">
        <div :class="formBox">
            <slot></slot>
        </div>
    </div>
</template>
<script setup>
    const templatestyle = "h-screen w-screen flex items-center justify-center"
    const backgroundstyle = "backcustom"
    const formBox = 'w-[80%] md:w-[60%] max-h-[80%]  md:min-h-[200px] glassBackground rounded-xl flex items-center justify-center p-4 md:p-8'

</script>
<style>
.backcustom {
    background: #051937; 
    background: -webkit-linear-gradient(to right bottom, #051937, #003452, #00505d, #006b59, #4d824d); 
    background: linear-gradient(to right bottom, #051937, #003452, #00505d, #006b59, #4d824d);

}

.backcustom::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: radial-gradient(white 1px, transparent 1px);
    background-size: 40px 35px; /* Mengatur jarak antar dot */
    opacity: 0.2; /* Mengatur transparansi dot */
    pointer-events: none; /* Mengabaikan klik */
}






.glassBackground{
    background: rgba(233, 233, 233, 0.537);
    -webkit-backdrop-filter: blur(5px);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(0, 255, 102, 0.312);
    
}
    
</style>