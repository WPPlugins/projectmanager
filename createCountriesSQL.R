countries <- read.table("Countries.txt", sep="\t", header=T, quote="")

mysql_table <- "$wpdb->projectmanager_countries"

# new database setup
sink("CountriesSQL.php", split=T)
cat("<?php\n");
for (r in 1:nrow(countries)) {
	if (countries[r,]$Code != "") {
		cat(paste("if ($wpdb->get_var(\"SELECT COUNT(ID) FROM {", mysql_table, "} WHERE code = '", countries[r,]$Code, "'\") == 0) {\n", sep=""))
		cat(paste("    $wpdb->query( $wpdb->prepare(\"INSERT INTO {", mysql_table, "} (code, name, region_code, region_name, code2) VALUES ('", countries[r,]$Code, "', '%s', '%s', '%s', '%s')\", \"",countries[r,]$Name,"\", \"",countries[r,]$RegionCode,"\", \"",countries[r,]$RegionName,"\", \"",countries[r,]$Code2,"\" ));\n", sep=""))
		cat("}\n")
	}
}
cat("?>");
sink()

# SQL dump for inserting new countries
mysql_table <- "wp_projectmanager_countries"
sink("Countries.sql", split=T)
for (r in 1:nrow(countries)) {
	if (countries[r,]$Code != "") {
		name <- gsub("'", "\\\\'", countries[r,]$Name)
		name <- gsub('"', '\\\\"', name)
		cat(paste("INSERT INTO {", mysql_table, "} (code, name, region_code, region_name, code2) VALUES (\"", countries[r,]$Code, "\", \"", name, "\", \"", countries[r,]$RegionCode, "\", \"", countries[r,]$RegionName, "\", \"", countries[r,]$Code2, "\");\n", sep=""))
	}
}
sink()

# Countries translation
sink("Countries.pot", split=T)
for (r in 1:nrow(countries)) {
	cat("#: Countries Database\n")
	cat(paste("msgid \"", countries[r,]$Name, "\"\n", sep=""))
	cat("msgstr \"\"\n\n")
}
sink()

mysql_table <- "$wpdb->projectmanager_countries"
sink("CountriesUpgrade.php", split=T)
cat("<?php\n");
for (r in 1:nrow(countries)) {
	if (countries[r,]$Code != "") {
		cat(paste("$wpdb->query( $wpdb->prepare(\"UPDATE {", mysql_table,"} SET `region_code` = '%s', `region_name` = '%s', `code2` = '%s' WHERE `code` = '",countries[r,]$Code,"'\", ", "\"", countries[r,]$RegionCode,"\", \"",countries[r,]$RegionName,"\", \"",countries[r,]$Code2,"\" ));\n", sep=""))
	}
}
cat("?>");
sink()