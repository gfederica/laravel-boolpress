<template>
  
    <footer>
        <div class="contacts">
            <ul class="d-flex">
                <li><a href="#">Telefono</a></li>
                <li><a href="#">Social</a></li>
                <li><a href="#">E-mail</a></li>
            </ul>
            <small>&copy BooleanCareers</small>
        </div>
    </footer>

</template>

<script>
export default {
    name: 'Footer'
}
</script>

<style lang="scss" scoped>
footer {
    
    padding-top: 30px;
    text-align: center;
    width: 40%;
    margin: auto;

    ul {
        justify-content: space-around;
         
         li {
            padding: 0 6px;
            list-style: none;
        }
    }
     
}
    
</style>