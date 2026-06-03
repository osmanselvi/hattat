# Hattat Portfolyo 🖋️

Bu proje, geleneksel İslam Sanatları (Hat sanatı) için tasarlanmış, sanatçının eserlerini sergileyebileceği, güncel duyurular yapabileceği ve öğrencileriyle etkileşimde bulunabileceği kapsamlı bir web platformudur.

Modern web standartlarına uygun olarak tasarlanan site, hem sanatseverlerin eserleri inceleyebileceği bir vitrin hem de öğrencilerin ödev/çalışma süreçlerini yönetebileceği bir eğitim portalı işlevi görmektedir.

## 🌟 Özellikler

- **Eser Galerisi**: Hattatın seçkin eserlerinin yüksek çözünürlüklü görsellerle sergilendiği ana galeri.
- **Sergiler**: Geçmiş ve gelecek sergilerin detayları, tarihleri ve konum bilgileri.
- **Haberler ve Duyurular**: Sanatçıyla ilgili güncel gelişmeler ve etkinlik duyuruları.
- **Öğrenci Paneli**:
  - Hattatın öğrencilerinin sisteme giriş yapabilmesi.
  - Öğrencilerin çalışmalarını (meşk/ödev) sisteme yükleyebilmesi.
  - Eğitmen tarafından çalışmalara geri bildirim (tashih) verilebilmesi.
  - Öğrenci ve eğitmen arası mesajlaşma sistemi.
- **Yönetim (Admin) Paneli**: 
  - Site ayarlarının (iletişim, sosyal medya vb.) yönetimi.
  - Eser, sergi ve haber ekleme/düzenleme/silme.
  - Öğrencilerin yönetimi ve ödev takibi.

## 🛠️ Kullanılan Teknolojiler

Bu proje, güçlü ve esnek bir altyapı üzerine inşa edilmiştir:

- **Backend**: [Symfony](https://symfony.com/) (PHP Framework)
- **Veritabanı**: MySQL (Doctrine ORM ile yönetiliyor)
- **Frontend**: Twig şablon motoru, HTML5, CSS3, JavaScript (AssetMapper ile modern JS yönetimi)
- **Arayüz/UI**: Bootstrap 5, Bootstrap Icons (Mobil uyumlu, duyarlı tasarım)
- **Güvenlik**: Symfony Security Bileşeni (Rol bazlı yetkilendirme: `ROLE_ADMIN`, `ROLE_STUDENT`)

## 🚀 Kurulum (Geliştiriciler İçin)

Projeyi kendi bilgisayarınızda çalıştırmak için aşağıdaki adımları izleyebilirsiniz:

### Gereksinimler
- PHP 8.1 veya üzeri
- Composer
- MySQL (veya MariaDB)
- Symfony CLI (isteğe bağlı ama önerilir)

### Adımlar

1. **Depoyu Klonlayın:**
   ```bash
   git clone https://github.com/osmanselvi/hattat.git
   cd hattat
   ```

2. **Bağımlılıkları Yükleyin:**
   ```bash
   composer install
   ```

3. **Çevre Değişkenlerini (Environment Variables) Ayarlayın:**
   - `.env` dosyasını kopyalayarak `.env.local` oluşturun.
   - `.env.local` dosyası içinde `DATABASE_URL` değişkenini kendi veritabanı bilgilerinize göre güncelleyin.
   ```env
   DATABASE_URL="mysql://kullanici_adi:sifre@127.0.0.1:3306/hattat_db?serverVersion=8.0.32&charset=utf8mb4"
   ```

4. **Veritabanını Oluşturun ve Tabloları Yükleyin:**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Sunucuyu Başlatın:**
   Eğer Symfony CLI kullanıyorsanız:
   ```bash
   symfony server:start
   ```
   *Alternatif olarak Apache veya Nginx ile de yapılandırabilirsiniz.*

## 📄 Lisans

Bu projenin tüm hakları saklıdır. (İhtiyaca göre MIT vb. bir lisans eklenebilir)
