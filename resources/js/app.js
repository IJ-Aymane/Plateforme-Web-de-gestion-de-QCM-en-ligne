document.addEventListener('DOMContentLoaded', () => {
    // Initialisation des icônes Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Logique des onglets (Tabs)
    const tabs = document.querySelectorAll('.tab');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetId = tab.dataset.tabTarget;
            const targetContent = document.getElementById(targetId);

            // Cacher tous les contenus d'onglets
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Réinitialiser le style de tous les onglets
            tabs.forEach(t => {
                t.classList.remove('active', 'text-primary', 'border-primary');
                t.classList.add('text-text-muted', 'border-transparent');
            });

            // Afficher le contenu de l'onglet cible
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }

            // Appliquer le style actif à l'onglet cliqué
            tab.classList.add('active', 'text-primary', 'border-primary');
            tab.classList.remove('text-text-muted', 'border-transparent');
        });
    });
});