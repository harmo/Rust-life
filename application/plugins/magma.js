function On_PlayerConnected(Player) {
	
	Web.POST("http://www.rust-life.fr/magma.php", "id=connexion&identifiant=" + Player.Name + "&steamid=" + Player.SteamID + "&adresseip=" + Player.IP);
}

function On_PlayerDisconnected(Player) {
	
	Web.POST("http://www.rust-life.fr/magma.php", "id=deconnexion&identifiant=" + Player.Name);
}

function On_Chat(Player, Message) {
	
	Web.POST("http://www.rust-life.fr/magma.php", "id=historique_tchat&identifiant=" + Player.Name + "&message=" + Message + "&steamid=" + Player.SteamID + "&adresseip=" + Player.IP);
}

function On_PlayerKilled(DeathEvent) {
	
	if(Data.GetTableValue(DeathEvent.Attacker.SteamID, "CONNEXION") == true) {
	
		if(DeathEvent.Attacker.Name == DeathEvent.Victim.Name) {
		
			Web.POST("http://www.rust-life.fr/magma.php", "id=suicide&identifiant=" + DeathEvent.Victim.Name);
			
			DeathEvent.Attacker.Message("Vous perdez 10% de votre argent !");
			
		} else {
						
			if(DeathEvent.Attacker.Name != "Bear" && DeathEvent.Attacker.Name != "MutantBear" && DeathEvent.Attacker.Name != "Wolf" && DeathEvent.Attacker.Name != "MutantWolf") {
				
				var Dist = Util.GetVectorsDistance(DeathEvent.Attacker.Location, DeathEvent.Victim.Location);
				var Distance = Number(Dist).toFixed(2);
				
				Web.POST("http://www.rust-life.fr/magma.php", "id=victime_humain&identifiant=" +  DeathEvent.Attacker.Name);
				Web.POST("http://www.rust-life.fr/magma.php", "id=mort_humain&identifiant=" +  DeathEvent.Victim.Name);
			}
		}
	}
	
	Web.POST("http://www.rust-life.fr/magma.php", "id=historique_mort&tueur=" +  DeathEvent.Attacker.Name + "&victime=" + DeathEvent.Victim.Name + "&arme=" + DeathEvent.WeaponName + "&distance=" + Distance + "&partie=" + DeathEvent.DamageEvent.bodyPart);
}

function On_NPCKilled(DeathEvent) {
	
	if(Data.GetTableValue(DeathEvent.Attacker.SteamID, "CONNEXION") == true) {
			
		switch (DeathEvent.Victim.Name) {
			
			case "MutantBear":
			case "Bear":
				
				DeathEvent.Attacker.Notice("Vous gagnez 30$ pour avoir tuer un ours !");
				Web.POST("http://www.rust-life.fr/magma.php", "id=victime_animal&identifiant=" + DeathEvent.Attacker.Name + "&animal=ours");
				
			break;
			
			case "MutantWolf":
			case "Wolf":
			
				DeathEvent.Attacker.Notice("Vous gagnez 20$ pour avoir tuer un loup !");
				Web.POST("http://www.rust-life.fr/magma.php", "id=victime_animal&identifiant=" + DeathEvent.Attacker.Name + "&animal=loups");
			
			break;
			
			case "Stag_A":
			
				DeathEvent.Attacker.Notice("Vous gagnez 10$ pour avoir tuer un cerf !");
				Web.POST("http://www.rust-life.fr/magma.php", "id=victime_animal&identifiant=" + DeathEvent.Attacker.Name + "&animal=cerfs");
				
			break;
			
			case "Boar_A":
				
				DeathEvent.Attacker.Notice("Vous gagnez 5$ pour avoir tuer un cochon !");
				Web.POST("http://www.rust-life.fr/magma.php", "id=victime_animal&identifiant=" + DeathEvent.Attacker.Name + "&animal=cochons");
				
			break;
		}
	}
}
