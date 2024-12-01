# Raydium PHP SDK

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/PHP-%5E8.2-blue)](https://www.php.net/releases/8.2/)
![PHPUnit Tests](https://github.com/jopanel/raydium-php-sdk/actions/workflows/phpunit.yml/badge.svg)


A robust and developer-friendly PHP SDK for interacting with the Raydium DeFi platform. This library simplifies access to Raydium's comprehensive API, enabling seamless integration with its pools, farms, mints, and IDO functionalities. Perfect for building scalable and efficient decentralized finance applications with PHP.

## 🚀 Features
- Lightweight and fully PSR-4 compliant
- [Supports Raydium V3 API](https://api-v3.raydium.io/docs/#/)
- Built-in extensibility for future methods
- Clean and intuitive API design
- Open source and community-friendly
- PHP 8.2+ Required

## 📚 Installation

Install the library via Composer:

```bash
composer require josephopanel/raydium-php-sdk
```

## 📖 Documentation

For detailed information about all available methods, visit the [API Documentation](docs/API.md).

---

## API Endpoints

- [Main API Version](docs/API.md#getversion)
- [UI RPCs](docs/API.md#getrpcs)
- [Chain Time](docs/API.md#getchaintime)
- [TVL and 24-Hour Volume](docs/API.md#getinfo)
- [RAY Stake Pools](docs/API.md#getstakepools)
- [Migrate LP Pool List](docs/API.md#getmigratelp)
- [Transaction Auto Fee](docs/API.md#getautofee)
- [CLMM Config](docs/API.md#getclmmconfig)
- [CPMM Config](docs/API.md#getcpmmconfig)
- [Default Mint List](docs/API.md#getlist)
- [Mint Info](docs/API.md#getmintinfo)
- [Mint Price](docs/API.md#getmintprice)
- [Pool Info by IDs](docs/API.md#getpoolinfobyids)
- [Pool Info by LP Mint](docs/API.md#getpoolinfobylps)
- [Pool Info List](docs/API.md#getallpoolsinfo)
- [Pool Info by Token Mint](docs/API.md#getpoolinfobytokenmint)
- [Pool Key by IDs](docs/API.md#getpoolkeysbyids)
- [Pool Liquidity History](docs/API.md#getpoolliquidityhistory)
- [CLMM Position](docs/API.md#getpoolpositionhistory)
- [Farm Pool Info by IDs](docs/API.md#getfarminfobyids)
- [Farm Pool Info by LP Mint](docs/API.md#getfarminfobylp)
- [Farm Pool Key by IDs](docs/API.md#getfarmkeysbyids)
- [IDO Pool Keys by IDs](docs/API.md#getidopoolkeys)

---

## 💻 Contributing

Contributions are welcome! If you'd like to improve the SDK or add new features, feel free to fork the repository and submit a pull request.

1. Fork the repository
2. Create a new feature branch: `git checkout -b feature/my-feature`
3. Commit your changes: `git commit -m "Add new feature"`
4. Push to the branch: `git push origin feature/my-feature`
5. Open a pull request

---

## 💰 Donations

This project is open source and developed with passion. If you’d like to support ongoing development, consider donating:

- **Solana Wallet Address**: `4izNYzN7uQac8jBDcD7NmuCpS8PqvYiHVSLXF5bY9Zrg`

Every little bit helps keep this project maintained and up-to-date. Thank you for your support! ❤️

---

## 📜 License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

---

## 📞 Contact

For any questions, feedback, or collaboration inquiries, feel free to reach out:

- **Author**: Joseph Opanel
- **Email**: [opanelj@gmail.com](mailto:opanelj@gmail.com)