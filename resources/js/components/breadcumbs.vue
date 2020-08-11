<template>
<section>
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li v-for="(crumb, index) in crumbs" :class="{ 'is-active' : index === crumbs.length - 1 }"><a :href="crumb.url">{{ crumb.name }}</a></li>
        </ul>
    </nav>
</section>
</template>

<script>
export default {
    name: "Breadcrumbs",
    props: {
        crumbs: {
            default: () => [],
            type: Array
        }
    }
}
</script>
