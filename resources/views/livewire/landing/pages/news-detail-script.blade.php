<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('newsShare', (shareUrl, shareTitle, shareExcerpt) => ({
            showShareMenu: false,
            shareUrl: shareUrl,
            shareTitle: shareTitle,
            shareExcerpt: shareExcerpt,
            copied: false,
            canShareNative: false,
            showSekilasModal: false,

            init() {
                this.canShareNative = navigator.share ? true : false;
            },

            openModal() {
                this.showSekilasModal = true;
            },

            closeModal() {
                this.showSekilasModal = false;
            },

            async shareNative() {
                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: this.shareTitle,
                            text: this.shareExcerpt,
                            url: this.shareUrl
                        });
                    } catch (err) {
                        // User cancelled or error
                    }
                }
            },

            shareToFacebook() {
                window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(this.shareUrl), '_blank', 'width=600,height=400');
            },
            
            shareToTwitter() {
                const text = this.shareTitle + '\n' + this.shareExcerpt;
                window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(this.shareUrl) + '&text=' + encodeURIComponent(text), '_blank', 'width=600,height=400');
            },
            
            shareToWhatsApp() {
                const text = `*${this.shareTitle}*\n\n${this.shareExcerpt}\n\n${this.shareUrl}`;
                window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank');
            },
            
            async shareToInstagram() {
                await this.copyLink();
                window.open('https://www.instagram.com/', '_blank');
            },
            
            async shareToTikTok() {
                await this.copyLink();
                window.open('https://www.tiktok.com/', '_blank');
            },
            
            async shareToThreads() {
                const text = this.shareTitle + '\n' + this.shareExcerpt;
                window.open('https://www.threads.net/intent/post?text=' + encodeURIComponent(text + '\n\n' + this.shareUrl), '_blank', 'width=600,height=600');
            },
            
            shareToLinkedIn() {
                window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(this.shareUrl), '_blank', 'width=600,height=600');
            },
            
            shareToTelegram() {
                window.open('https://t.me/share/url?url=' + encodeURIComponent(this.shareUrl) + '&text=' + encodeURIComponent(this.shareTitle), '_blank');
            },
            
            shareToLine() {
                window.open('https://social-plugins.line.me/lineit/share?url=' + encodeURIComponent(this.shareUrl), '_blank');
            },
            
            shareToEmail() {
                window.open('mailto:?subject=' + encodeURIComponent(this.shareTitle) + '&body=' + encodeURIComponent(this.shareTitle + '\n\n' + this.shareExcerpt + '\n\n' + this.shareUrl), '_self');
            },
            
            async copyLink() {
                try {
                    await navigator.clipboard.writeText(this.shareUrl);
                    this.copied = true;
                    setTimeout(() => this.copied = false, 2000);
                } catch(e) {}
            }
        }));
    });
</script>
