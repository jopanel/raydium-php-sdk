## API Endpoints

- [Main API Version](#getversion)
- [UI RPCs](#getrpcs)
- [Chain Time](#getchaintime)
- [TVL and 24-Hour Volume](#getinfo)
- [RAY Stake Pools](#getstakepools)
- [Migrate LP Pool List](#getmigratelp)
- [Transaction Auto Fee](#getautofee)
- [CLMM Config](#getclmmconfig)
- [CPMM Config](#getcpmmconfig)
- [Default Mint List](#getlist)
- [Mint Info](#getmintinfo)
- [Mint Price](#getmintprice)
- [Pool Info by IDs](#getpoolinfobyids)
- [Pool Info by LP Mint](#getpoolinfobylps)
- [Pool Info List](#getallpoolsinfo)
- [Pool Info by Token Mint](#getpoolinfobytokenmint)
- [Pool Key by IDs](#getpoolkeysbyids)
- [Pool Liquidity History](#getpoolliquidityhistory)
- [CLMM Position](#getpoolpositionhistory)
- [Farm Pool Info by IDs](#getfarminfobyids)
- [Farm Pool Info by LP Mint](#getfarminfobylp)
- [Farm Pool Key by IDs](#getfarmkeysbyids)
- [IDO Pool Keys by IDs](#getidopoolkeys)

---

## 🛠 Usage

To get started, include the Composer autoloader and instantiate the relevant classes for accessing Raydium's API endpoints.

```php
require_once 'vendor/autoload.php';

use JosephOpanel\RaydiumSDK\V3\Main;
use JosephOpanel\RaydiumSDK\V3\Mint;
use JosephOpanel\RaydiumSDK\V3\Pools;
use JosephOpanel\RaydiumSDK\V3\Farms;
use JosephOpanel\RaydiumSDK\V3\IDO;

// Initialize the endpoint classes
$main = new Main();
$mint = new Mint();
$pools = new Pools();
$farms = new Farms();
$ido = new IDO();
```

Each class provides access to specific API endpoints, grouped by functionality:

- **Main**: Access general platform information, configuration, and utilities.
- **Mint**: Retrieve mint-related information such as token lists and prices.
- **Pools**: Fetch pool-specific data, including liquidity, positions, and keys.
- **Farms**: Access farm pool data, including APY and TVL.
- **IDO**: Retrieve Initial DEX Offering (IDO) pool keys and related data.

Use these classes to make API calls effortlessly, enabling seamless interaction with the Raydium platform in your PHP applications.

---

### Methods

## `getVersion` <a name="getversion"></a>

### What is `getVersion`?

The `getVersion` method fetches the current version of the Raydium UI V3.

- **Endpoint:** `/main/version`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `version` (string): The current version of the Raydium UI.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Main;

$main = new Main();

// Fetch the current UI V3 version
$version = $main->getVersion();
echo "Raydium UI Version: $version";
```

---

## `getRPCs` <a name="getrpcs"></a>

### What is `getRPCs`?

The `getRPCs` method fetches the list of RPC endpoints for the Raydium UI.

- **Endpoint:** `/main/rpcs`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `rpcs` (array): An array of RPC details, each including:
    - `url` (string): The RPC URL.
    - `status` (string): The status of the RPC (`online` or `offline`).

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Main;

$main = new Main();

// Fetch the RPCs
$rpcs = $main->getRPCs();
foreach ($rpcs as $rpc) {
    echo "RPC URL: {$rpc['url']} - Status: {$rpc['status']}\n";
}
```

---

## `getChainTime` <a name="getchaintime"></a>

### What is `getChainTime`?

The `getChainTime` method fetches the current chain time from the Raydium API.

- **Endpoint:** `/main/chain-time`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `chainTime` (string): The current chain time in ISO 8601 format.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Main;

$main = new Main();

// Fetch the chain time
$chainTime = $main->getChainTime();
echo "Current Chain Time: $chainTime";
```

---

## `getInfo` <a name="getinfo"></a>

### What is `getInfo`?

The `getInfo` method fetches the Total Value Locked (TVL) and 24-hour trading volume for the Raydium platform.

- **Endpoint:** `/main/info`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `tvl` (integer): The total value locked in the platform.
  - `volume24h` (integer): The 24-hour trading volume.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Main;

$main = new Main();

// Fetch the TVL and 24-hour volume
$info = $main->getInfo();
echo "TVL: {$info['tvl']} USD\n";
echo "24-hour Volume: {$info['volume24h']} USD\n";
```

---


## `getStakePools` <a name="getstakepools"></a>

### What is `getStakePools`?

The `getStakePools` method fetches details about the RAY stake pools available on the Raydium platform.

- **Endpoint:** `/main/stake-pools`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `stakePools` (array): An array of stake pool details, each including:
    - `id` (string): The unique identifier for the stake pool.
    - `tvl` (integer): The total value locked in the pool.
    - `apy` (float): The annual percentage yield for the pool.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Main;

$main = new Main();

// Fetch the RAY stake pools
$stakePools = $main->getStakePools();
foreach ($stakePools as $pool) {
    echo "Pool ID: {$pool['id']}, TVL: {$pool['tvl']} USD, APY: {$pool['apy']}%\n";
}
```

---


## `getMigrateLP` <a name="getmigratelp"></a>

### What is `getMigrateLP`?

The `getMigrateLP` method fetches the list of liquidity pools available for migration from old pools to new pools.

- **Endpoint:** `/main/migrate-lp`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `pools` (array): An array of LP pool details, each including:
    - `id` (string): The unique identifier for the LP pool.
    - `source` (string): The source pool identifier.
    - `destination` (string): The destination pool identifier.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Main;

$main = new Main();

// Fetch the Migrate LP Pool List
$migrateLP = $main->getMigrateLP();
foreach ($migrateLP as $pool) {
    echo "Pool ID: {$pool['id']}, Source: {$pool['source']}, Destination: {$pool['destination']}\n";
}
```

---


## `getAutoFee` <a name="getautofee"></a>

### What is `getAutoFee`?

The `getAutoFee` method fetches the automatic transaction fee configurations from the Raydium API.

- **Endpoint:** `/main/auto-fee`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `fees` (array): An array of fee configurations, each including:
    - `type` (string): The type of fee (e.g., `transaction`, `withdrawal`).
    - `amount` (float): The fee amount.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Main;

$main = new Main();

// Fetch the transaction auto-fee configurations
$autoFee = $main->getAutoFee();
foreach ($autoFee as $fee) {
    echo "Fee Type: {$fee['type']}, Amount: {$fee['amount']}\n";
}
```

---

## `getClmmConfig` <a name="getclmmconfig"></a>

### What is `getClmmConfig`?

The `getClmmConfig` method fetches the configuration for the Concentrated Liquidity Market Maker (CLMM) from the Raydium API.

- **Endpoint:** `/main/clmm-config`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `config` (array): The configuration details, including:
    - `tickSpacing` (integer): The spacing between ticks.
    - `maxLiquidity` (integer): The maximum liquidity allowed.
    - `minLiquidity` (integer): The minimum liquidity required.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Main;

$main = new Main();

// Fetch the CLMM configuration
$clmmConfig = $main->getClmmConfig();
echo "Tick Spacing: {$clmmConfig['tickSpacing']}\n";
echo "Max Liquidity: {$clmmConfig['maxLiquidity']}\n";
echo "Min Liquidity: {$clmmConfig['minLiquidity']}\n";
```

---

## `getCpmmConfig` <a name="getcpmmconfig"></a>

### What is `getCpmmConfig`?

The `getCpmmConfig` method fetches the configuration for the Constant Product Market Maker (CPMM) from the Raydium API.

- **Endpoint:** `/main/cpmm-config`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `config` (array): The configuration details, including:
    - `feeRate` (float): The fee rate for swaps.
    - `minLiquidity` (integer): The minimum liquidity required.
    - `maxLiquidity` (integer): The maximum liquidity allowed.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Main;

$main = new Main();

// Fetch the CPMM configuration
$cpmmConfig = $main->getCpmmConfig();
echo "Fee Rate: {$cpmmConfig['feeRate']}\n";
echo "Min Liquidity: {$cpmmConfig['minLiquidity']}\n";
echo "Max Liquidity: {$cpmmConfig['maxLiquidity']}\n";
```

---


## `getList` <a name="getlist"></a>

### What is `getList`?

The `getList` method fetches the default list of mints available in the Raydium platform.

- **Endpoint:** `/mint/list`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `mints` (array): An array of mint details, each including:
    - `address` (string): The mint address.
    - `name` (string): The name of the token.
    - `symbol` (string): The token symbol.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Mint;

$mint = new Mint();

// Fetch the default mint list
$mintList = $mint->getList();
foreach ($mintList as $mint) {
    echo "Address: {$mint['address']}, Name: {$mint['name']}, Symbol: {$mint['symbol']}\n";
}
```

---

## `getMintInfo` <a name="getmintinfo"></a>

### What is `getMintInfo`?

The `getMintInfo` method fetches detailed information about specific mints on the Raydium platform using their IDs.

- **Endpoint:** `/mint/ids`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`ids`** (array): An array of mint IDs to query.
- **Response:**
  - `mints` (array): An array of mint details, each including:
    - `id` (string): The mint ID.
    - `name` (string): The name of the token.
    - `symbol` (string): The token symbol.
    - `decimals` (integer): The number of decimals for the token.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Mint;

$mint = new Mint();

// Fetch details for specific mints
$mintInfo = $mint->getMintInfo(['mint1', 'mint2']);
foreach ($mintInfo as $mint) {
    echo "ID: {$mint['id']}, Name: {$mint['name']}, Symbol: {$mint['symbol']}, Decimals: {$mint['decimals']}\n";
}
```

---

## `getMintPrice` <a name="getmintprice"></a>

### What is `getMintPrice`?

The `getMintPrice` method fetches the current price information for specific mints on the Raydium platform.

- **Endpoint:** `/mint/price`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`ids`** (array): An array of mint IDs to query prices for.
- **Response:**
  - `prices` (array): An associative array of mint prices, where:
    - Key: Mint ID.
    - Value: Current price (float).

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Mint;

$mint = new Mint();

// Fetch current prices for specific mints
$mintPrices = $mint->getMintPrice(['mint1', 'mint2']);
foreach ($mintPrices as $mintId => $price) {
    echo "Mint ID: $mintId, Price: $price USD\n";
}
```

---

## `getPoolInfoByIds` <a name="getpoolinfobyids"></a>

### What is `getPoolInfoByIds`?

The `getPoolInfoByIds` method fetches detailed information about specific pools on the Raydium platform using their IDs.

- **Endpoint:** `/pools/info/ids`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`ids`** (array): An array of pool IDs to query.
- **Response:**
  - `pools` (array): An array of pool details, each including:
    - `id` (string): The pool ID.
    - `tvl` (integer): The total value locked in the pool.
    - `apy` (float): The annual percentage yield for the pool.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Pools;

$pools = new Pools();

// Fetch details for specific pools
$poolInfo = $pools->getPoolInfoByIds(['pool1', 'pool2']);
foreach ($poolInfo as $pool) {
    echo "Pool ID: {$pool['id']}, TVL: {$pool['tvl']} USD, APY: {$pool['apy']}%\n";
}
```

---

## `getPoolInfoByLPs` <a name="getpoolinfobylps"></a>

### What is `getPoolInfoByLPs`?

The `getPoolInfoByLPs` method fetches detailed information about pools on the Raydium platform using their LP mint addresses.

- **Endpoint:** `/pools/info/lps`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`lpMints`** (array): An array of LP mint addresses to query.
- **Response:**
  - `pools` (array): An array of pool details, each including:
    - `lpMint` (string): The LP mint address.
    - `tvl` (integer): The total value locked in the pool.
    - `apy` (float): The annual percentage yield for the pool.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Pools;

$pools = new Pools();

// Fetch pool details using LP mint addresses
$poolInfo = $pools->getPoolInfoByLPs(['lp1', 'lp2']);
foreach ($poolInfo as $pool) {
    echo "LP Mint: {$pool['lpMint']}, TVL: {$pool['tvl']} USD, APY: {$pool['apy']}%\n";
}
```

---

## `getAllPoolsInfo` <a name="getallpoolsinfo"></a>

### What is `getAllPoolsInfo`?

The `getAllPoolsInfo` method fetches detailed information about all pools on the Raydium platform.

- **Endpoint:** `/pools/info/list`
- **HTTP Method:** `GET`
- **Parameters:** None
- **Response:**
  - `pools` (array): An array of pool details, each including:
    - `id` (string): The pool ID.
    - `tvl` (integer): The total value locked in the pool.
    - `apy` (float): The annual percentage yield for the pool.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Pools;

$pools = new Pools();

// Fetch information for all pools
$allPools = $pools->getAllPoolsInfo();
foreach ($allPools as $pool) {
    echo "Pool ID: {$pool['id']}, TVL: {$pool['tvl']} USD, APY: {$pool['apy']}%\n";
}
```

---

## `getPoolInfoByTokenMint` <a name="getpoolinfobytokenmint"></a>

### What is `getPoolInfoByTokenMint`?

The `getPoolInfoByTokenMint` method fetches detailed information about pools on the Raydium platform using their token mint addresses.

- **Endpoint:** `/pools/info/mint`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`tokenMints`** (array): An array of token mint addresses to query.
- **Response:**
  - `pools` (array): An array of pool details, each including:
    - `tokenMint` (string): The token mint address.
    - `tvl` (integer): The total value locked in the pool.
    - `apy` (float): The annual percentage yield for the pool.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Pools;

$pools = new Pools();

// Fetch pool details using token mint addresses
$poolInfo = $pools->getPoolInfoByTokenMint(['mint1', 'mint2']);
foreach ($poolInfo as $pool) {
    echo "Token Mint: {$pool['tokenMint']}, TVL: {$pool['tvl']} USD, APY: {$pool['apy']}%\n";
}
```

---

## `getPoolKeysByIds` <a name="getpoolkeysbyids"></a>

### What is `getPoolKeysByIds`?

The `getPoolKeysByIds` method fetches key information for pools on the Raydium platform using their pool IDs.

- **Endpoint:** `/pools/key/ids`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`ids`** (array): An array of pool IDs to query.
- **Response:**
  - `keys` (array): An array of pool key details, each including:
    - `id` (string): The pool ID.
    - `key` (string): The associated key.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Pools;

$pools = new Pools();

// Fetch pool keys using pool IDs
$poolKeys = $pools->getPoolKeysByIds(['pool1', 'pool2']);
foreach ($poolKeys as $pool) {
    echo "Pool ID: {$pool['id']}, Key: {$pool['key']}\n";
}
```

---

## `getPoolLiquidityHistory` <a name="getpoolliquidityhistory"></a>

### What is `getPoolLiquidityHistory`?

The `getPoolLiquidityHistory` method fetches historical liquidity data for pools on the Raydium platform.

- **Endpoint:** `/pools/line/liquidity`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`ids`** (array): An array of pool IDs to query.
- **Response:**
  - `liquidityHistory` (array): An array of liquidity history data, each including:
    - `id` (string): The pool ID.
    - `date` (string): The date of the liquidity data (in YYYY-MM-DD format).
    - `liquidity` (integer): The liquidity value on that date.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Pools;

$pools = new Pools();

// Fetch liquidity history for specific pools
$liquidityHistory = $pools->getPoolLiquidityHistory(['pool1', 'pool2']);
foreach ($liquidityHistory as $liquidity) {
    echo "Pool ID: {$liquidity['id']}, Date: {$liquidity['date']}, Liquidity: {$liquidity['liquidity']}\n";
}
```

---

## `getPoolPositionHistory` <a name="getpoolpositionhistory"></a>

### What is `getPoolPositionHistory`?

The `getPoolPositionHistory` method fetches historical position data for pools on the Raydium platform.

- **Endpoint:** `/pools/line/position`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`ids`** (array): An array of pool IDs to query.
- **Response:**
  - `positionHistory` (array): An array of position history data, each including:
    - `id` (string): The pool ID.
    - `date` (string): The date of the position data (in YYYY-MM-DD format).
    - `position` (integer): The position value on that date.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Pools;

$pools = new Pools();

// Fetch position history for specific pools
$positionHistory = $pools->getPoolPositionHistory(['pool1', 'pool2']);
foreach ($positionHistory as $position) {
    echo "Pool ID: {$position['id']}, Date: {$position['date']}, Position: {$position['position']}\n";
}
```

---

## `getFarmInfoByIds` <a name="getfarminfobyids"></a>

### What is `getFarmInfoByIds`?

The `getFarmInfoByIds` method fetches detailed information about farm pools on the Raydium platform using their farm IDs.

- **Endpoint:** `/farms/info/ids`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`ids`** (array): An array of farm IDs to query.
- **Response:**
  - `farms` (array): An array of farm pool details, each including:
    - `id` (string): The farm ID.
    - `tvl` (integer): The total value locked in the farm.
    - `apy` (float): The annual percentage yield for the farm.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Farms;

$farms = new Farms();

// Fetch details for specific farms
$farmInfo = $farms->getFarmInfoByIds(['farm1', 'farm2']);
foreach ($farmInfo as $farm) {
    echo "Farm ID: {$farm['id']}, TVL: {$farm['tvl']} USD, APY: {$farm['apy']}%\n";
}
```

---

## `getFarmInfoByLP` <a name="getfarminfobylp"></a>

### What is `getFarmInfoByLP`?

The `getFarmInfoByLP` method fetches detailed information about farm pools on the Raydium platform using their LP mint addresses.

- **Endpoint:** `/farms/info/lp`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`lpMints`** (array): An array of LP mint addresses to query.
- **Response:**
  - `farms` (array): An array of farm pool details, each including:
    - `lpMint` (string): The LP mint address.
    - `tvl` (integer): The total value locked in the farm.
    - `apy` (float): The annual percentage yield for the farm.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Farms;

$farms = new Farms();

// Fetch farm details using LP mint addresses
$farmInfo = $farms->getFarmInfoByLP(['lp1', 'lp2']);
foreach ($farmInfo as $farm) {
    echo "LP Mint: {$farm['lpMint']}, TVL: {$farm['tvl']} USD, APY: {$farm['apy']}%\n";
}
```

---

## `getFarmKeysByIds` <a name="getfarmkeysbyids"></a>

### What is `getFarmKeysByIds`?

The `getFarmKeysByIds` method fetches key information for farm pools on the Raydium platform using their farm IDs.

- **Endpoint:** `/farms/key/ids`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`ids`** (array): An array of farm IDs to query.
- **Response:**
  - `keys` (array): An array of farm key details, each including:
    - `id` (string): The farm ID.
    - `key` (string): The associated key.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\Farms;

$farms = new Farms();

// Fetch farm keys using farm IDs
$farmKeys = $farms->getFarmKeysByIds(['farm1', 'farm2']);
foreach ($farmKeys as $farm) {
    echo "Farm ID: {$farm['id']}, Key: {$farm['key']}\n";
}
```

---

## `getIDOPoolKeys` <a name="getidopoolkeys"></a>

### What is `getIDOPoolKeys`?

The `getIDOPoolKeys` method fetches key information for IDO pools on the Raydium platform using their IDs.

- **Endpoint:** `/ido/key/ids`
- **HTTP Method:** `GET`
- **Parameters:**
  - **`ids`** (array): An array of IDO pool IDs to query.
- **Response:**
  - `keys` (array): An array of IDO pool key details, each including:
    - `id` (string): The IDO pool ID.
    - `key` (string): The associated key.

---

### Example Usage

```php
use JosephOpanel\RaydiumSDK\V3\IDO;

$ido = new IDO();

// Fetch IDO pool keys using IDO IDs
$idoKeys = $ido->getIDOPoolKeys(['ido1', 'ido2']);
foreach ($idoKeys as $ido) {
    echo "IDO ID: {$ido['id']}, Key: {$ido['key']}\n";
}
```

---