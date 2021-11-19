<template>
  <picture>
    <source media="(min-width:1140px)" :srcset="`${xlPath}.avif`" type="image/avif">
    <source media="(min-width:960px)" :srcset="`${lgPath}.avif`" type="image/avif">
    <source media="(min-width:720px)" :srcset="`${mdPath}.avif`" type="image/avif">
    <source media="(min-width:540px)" :srcset="`${smPath}.avif`" type="image/avif">
    <source :srcset="`${xsPath}.avif`" type="image/avif">
    <source media="(min-width:1140px)" :srcset="`${xlPath}.${ext}`">
    <source media="(min-width:960px)" :srcset="`${lgPath}.${ext}`">
    <source media="(min-width:720px)" :srcset="`${mdPath}.${ext}`">
    <source media="(min-width:540px)" :srcset="`${smPath}.${ext}`">
    <source :srcset="`${xsPath}.${ext}`">
    <img :src="originalPath" :alt="altString" v-bind="$attrs"/>
  </picture>
</template>

<script>
export default {
  name: "S3Image",
  props: {
    file: Object,
    alt: String,
    xl: Number,
    lg: Number,
    md: Number,
    sm: Number,
    xs: Number,
  },
  computed: {
    ext() {
      return this.file.ext;
    },
    originalPath() {
      return `${this.file.url}${this.file.path}`;
    },
    xlPath() {
      const size =  2400 * (this.xl / 10);
      return `${this.file.url}${size}/${this.file.name}`;
    },
    lgPath() {
      const size =  1140 * (this.lg / 10);
      return `${this.file.url}${size}/${this.file.name}`;
    },
    mdPath() {
      const size =  960 * (this.md / 10);
      return `${this.file.url}${size}/${this.file.name}`;
    },
    smPath() {
      const size =  720 * (this.sm / 10);
      return `${this.file.url}${size}/${this.file.name}`;
    },
    xsPath() {
      const size =  540 * (this.xs / 10);
      return `${this.file.url}${size}/${this.file.name}`;
    },
    altString() {
      return this.alt ? this.alt : this.file.alt;
    }
  }
}
</script>

