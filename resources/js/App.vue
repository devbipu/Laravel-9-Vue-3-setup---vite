<template>
	<header>
		<router-link to="/">Home</router-link>
		<router-link to="/about">About</router-link>
	</header>
	<main>
		<router-view></router-view>
	</main>
</template>


<style>
	*{
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}
	header a{
		display: inline-block;
		padding: 0 10px;
		text-decoration: none;
	}
	header a.router-link-active{
		text-decoration: underline;
	}
	main{
		padding: 10px;
	}
</style>