<?php
if ($_POST):
	require 'process.php';
	exit;
endif
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		table {border: 0; width: 100%;}
		th, td {padding: 5px 0; text-align: center; vertical-align: top;}
		td.data-buttons {white-space: nowrap;}
		input {width: 95%;}
		input[name=url] {width: 70%;}
		iframe[name=target] {width: 100%; height: 100%; border: 0;}
		iframe[name=target] body {font-family: "monospace";}
	</style>
</head>
<body>
	<table id="wrapper">
		<tr style="background: lightgray;">
			<th>Request</th>
			<th>
				Response
				<small style="font-weight: normal;" v-text="responseTime" v-if="responseTime !== null"></small>
			</th>
		</tr>
		<tr>
			<td style="width: 40%;">
				<form method="post" target="target" @submit="sendRequest()" :enctype="{'multipart/form-data': dataContainsFile}">
					<select name="method" v-model="method">
						<option v-for="m in reqMethods" v-text="m"></option>
					</select>
					<input type="url" name="url" placeholder="URL" required="" autofocus="">
					<button type="submit">Send</button>
					<table>
						<thead>
							<tr><th colspan="1">Header</th></tr>
						</thead>
						<tbody>
							<tr v-for="(h,i) in headers">
								<td style="width: 90%;">
									<input type="text" name="headers[]" v-model="h" placeholder="Header" autocomplete="off">
								</td>
								<td class="data-buttons">
									<button type="button" @click="delHeader(i)">-</button>
									<button type="button" @click="addHeader()">+</button>
								</td>
							</tr>
						</tbody>
					</table>
					<table>
						<thead>
							<tr>
								<th colspan="4">
									Body
									<select v-model="bodyType" @change="onBodyTypeChange()">
										<option value="">form</option>
										<option>json</option>
										<option>raw</option>
									</select>
								</th>
							</tr>
						</thead>
						<tbody v-if="!rawBody">
							<tr v-for="(x,i) in data">
								<td style="width: 40%;">
									<input type="text" name="names[]" v-model="x[0]" placeholder="Name" autocomplete="off">
								</td>
								<td>
									<select name="types[]" v-model="x[1]">
										<option v-for="v in valueTypes" v-text="v"></option>
									</select>
								</td>
								<td style="width: 40%;">
									<input v-if="x[1]=='text'" type="text" name="values[]" v-model="x[2]" placeholder="Value" autocomplete="off">
									<input v-if="x[1]=='file'" type="file" name="values[]" v-model="x[2]" placeholder="Value" autocomplete="off">
								</td>
								<td class="data-buttons">
									<button type="button" @click="delPayload(i)">-</button>
									<button type="button" @click="addPayload()">+</button>
								</td>
							</tr>
						</tbody>
						<tbody v-if="rawBody">
							<tr>
								<td><textarea name="raw" rows="7" style="width: 100%;"></textarea></td>
							</tr>
						</tbody>
					</table>
				</form>
			</td>
			<td style="width: 60%;">
				<iframe name="target" @load="onResponse()"></iframe>
			</td>
		</tr>
	</table>
	<script type="text/javascript" src="jquery.min.js"></script>
	<script type="text/javascript" src="vue.min.js"></script>
	<script type="text/javascript" src="rest.js"></script>
</body>
</html>