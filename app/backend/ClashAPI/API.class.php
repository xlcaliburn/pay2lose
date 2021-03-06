<?php

require_once "League.class.php";
require_once "Location.class.php";
require_once "Clan.class.php";
require_once "Member.class.php";

/**
 * Class to get JSON-decoded arrays containing information provided by SuperCell's official Clash of Clans API located at https://developer.clashofclans.com
 */

class ClashOfClans
{
	private $_apiKey = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6ImI5ZTdmMTZmLTA4MjgtNDJhNS1iZDc2LTIwN2I2MzQ1ZWMzZSIsImlhdCI6MTQ1Njg5NzYzMSwic3ViIjoiZGV2ZWxvcGVyL2UxZjRkNzliLTVjNzQtYTc5MC02NTc1LWIzN2ExZjg3ZmQxZSIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjk5LjIzNS4yMjkuOTIiLCI2Ni45Ni4xODMuNTMiXSwidHlwZSI6ImNsaWVudCJ9XX0.IW9qjL_LmscqQa_t9m-kF-r1KGnHf1KxuwIJnK_k9VKLsrcFyt3PxbxOeXalhK8-XPnrWiD7-7EckNGcVeYfGQ";
	
	/**
	 * Send a Request to SuperCell's Servers and contains the authorization-Token.
	 *
	 * @param string $url
	 * @return string; response from API (json)
	 */
	protected function sendRequest($url)
	{
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Accept: application/json',
  			'authorization: Bearer '.$this->_apiKey // 
		));
		$output = curl_exec($ch);
		curl_close($ch); 

		return $output;
	}

	/**
	 * Search all clans by name
	 *
	 * @param $searchString, the clan name, e.g. foxforcefürth
	 * @return array, search results.
	 */
	public function searchClanByName($searchString)
	{
		$json = $this->sendRequest("https://api.clashofclans.com/v1/clans?name=".urlencode($searchString));
		return json_decode($json);
	}

	/** 
	 * Search for clans by using multiple parameters
	 * 
	 * @param array
	 * @return array
	 */
	public function searchClan($parameters)
	{
		/*
		Array can have these indexes: 
		* name (string)
		* warFrequency (string, {"always", "moreThanOncePerWeek", "oncePerWeek", "lessThanOncePerWeek", "never", "unknown"})
		* locationId (integer)
		* minMembers (integer)
		* maxMembers (integer)
		* minClanPoints (integer)
		* minClanLevel (integer)
		* limit (integer)
		* after (integer)
		* before (integer)
		For more information, take a look at the official documentation: https://developer.clashofclans.com/#/documentation
		*/

		$json = $this->sendRequest("https://api.clashofclans.com/v1/clans?".http_build_query($parameters));
		return json_decode($json);
	}


	/**
	 * Get information of a clan
	 *
	 * @param $tag, clantag. (e.g. #22UCCU0J)
	 * @return array, clan information.
	 */
	public function getClanByTag($tag) //#22UCCU0J = foxforcefürth
	{
		$json = $this->sendRequest("https://api.clashofclans.com/v1/clans/".urlencode($tag));
		return json_decode($json);
	}

	/**
	 * Get information about the membersof a clan
	 *
	 * @param $tag, clantag. (e.g. #22UCCU0J)
	 * @return array, member information.
	 */
	public function getClanMembersByTag($tag)
	{
		$json = $this->sendRequest("https://api.clashofclans.com/v1/clans/".urlencode($tag)."/members");
		return json_decode($json);
	}

	/**
	 * Get a list of all locations supported by SuperCell's Clan-System
	 *
	 * @return array, all locations.
	 */
	public function getLocationList()
	{
		$json = $this->sendRequest("https://api.clashofclans.com/v1/locations");
		return json_decode($json);
	}

	/**
	 * Get information about a location by providing it's id.
	 *
	 * @param $locationId
	 * @return array, location info.
	 */
	public function getLocationInfo($locationId) //32000094 = Germany
	{
		$json = $this->sendRequest("https://api.clashofclans.com/v1/locations/".$locationId);
		return json_decode($json);
	}

	/**
	 * Get information about all leages.
	 *
	 * @return array, league info.
	 */
	public function getLeagueList()
	{
		$json = $this->sendRequest("https://api.clashofclans.com/v1/leagues");
		return json_decode($json);
	}

	/**
	 * Get ranklist information about players or clans
	 *
	 * @param $locationId (tip: 32000006 is "International")
	 * @param (optional) $clans
	 * @return array, location info.
	 */
	public function getRankList($locationId, $clans = false) //if clans is not set to true, return player ranklist
	{
		if ($clans)
		{
			$json = $this->sendRequest("https://api.clashofclans.com/v1/locations/".$locationId."/rankings/clans");
		}
		else
		{
			$json = $this->sendRequest("https://api.clashofclans.com/v1/locations/".$locationId."/rankings/clans");
		}
		return json_decode($json);
	}
};

?>