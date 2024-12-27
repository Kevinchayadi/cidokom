<template>
    <div :class="[templatestyle, backgroundstyle]">
        <div :class="formBox">
            <slot></slot>
        </div>
    </div>
</template>
<script setup>
    const templatestyle = "min-h-screen w-full flex items-center p-xl justify-center"
    const backgroundstyle = "backcustom"
    const formBox = 'w-[80%] md:w-[60%] md:min-h-[200px] my-10 glassBackground rounded-xl flex items-center justify-center p-4 md:p-8'

</script>
<style scoped>
.backcustom {
    /* background: #051937;  */
    /* background: -webkit-linear-gradient( to top, #051937, #002e4b, #004248, #00532f,#435e07); 
    background: linear-gradient(to to top, #051937, #002e4b, #004248, #00532f,#435e07); */
    background-image: url('../../../public/img/background.png');


}

.glassBackground{
    background: rgba(164, 164, 164, 0.537);
    -webkit-backdrop-filter: blur(5px);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.312);
    
}
    
</style>