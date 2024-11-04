<template>
    <div :class="[templatestyle, backgroundstyle]">
        <div :class="formBox">
            <slot></slot>
        </div>
    </div>
</template>
<script setup>
    const templatestyle = "h-screen w-screen flex items-center justify-center"
    const backgroundstyle = "bg-primary-background"
    const formBox = 'w-[80%] md:w-[60%] max-h-[80%]  md:min-h-[200px] glassBackground rounded-xl flex items-center justify-center p-4 md:p-8'

</script>
<style>




.glassBackground{
    background: rgba(80, 80, 80, 0.537);
    -webkit-backdrop-filter: blur(5px);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.312);
    
}
    
</style>