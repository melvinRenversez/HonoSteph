# ============================================
# Script : generate_catalogue_hqs_claire_standard.py
# Objet  : Génération du Catalogue Évolutif HQS – Version Claire (fond blanc)
# Auteur : HQS Solutions / Octobre 2025
# ============================================

from reportlab.lib.pagesizes import A4
from reportlab.lib import colors
from reportlab.lib.units import cm
from reportlab.platypus import (
    SimpleDocTemplate, Paragraph, Spacer, Image, PageBreak, Table, TableStyle
)
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.pdfgen import canvas
from reportlab.lib.enums import TA_CENTER, TA_LEFT

# --- CONFIGURATION GÉNÉRALE ---
PAGE_WIDTH, PAGE_HEIGHT = A4
MARGES = 2 * cm
LOGO_PATH = "HQS logo final.jpg"  # chemin vers ton logo
PDF_NAME = "Catalogue_HQS_Version_Claire.pdf"

# --- FONCTION PIED DE PAGE + NUMÉROTATION ---
def add_page_number(canvas, doc):
    page_num = canvas.getPageNumber()
    text = f"Page {page_num}"
    canvas.setFont("Helvetica", 9)
    canvas.drawRightString(PAGE_WIDTH - MARGES, 1.2 * cm, text)
    canvas.drawString(MARGES, 1.2 * cm, "Édition octobre 2025 – Catalogue évolutif HQS")

# --- STYLES ---
styles = getSampleStyleSheet()
styles.add(ParagraphStyle(name="TitrePrincipal", fontSize=22, alignment=TA_CENTER, spaceAfter=20))
styles.add(ParagraphStyle(name="SousTitre", fontSize=14, alignment=TA_CENTER, textColor=colors.HexColor("#004C97")))
styles.add(ParagraphStyle(name="Texte", fontSize=11, leading=16, alignment=TA_LEFT))
styles.add(ParagraphStyle(name="TitreProduit", fontSize=14, textColor=colors.HexColor("#004C97"), spaceAfter=6))
styles.add(ParagraphStyle(name="Carac", fontSize=11, leftIndent=10))

# --- DOCUMENT ---
doc = SimpleDocTemplate(PDF_NAME, pagesize=A4,
                        leftMargin=MARGES, rightMargin=MARGES,
                        topMargin=MARGES, bottomMargin=2*cm)

elements = []

# --- PAGE DE GARDE ---
elements.append(Spacer(1, 6*cm))
elements.append(Image(LOGO_PATH, width=5*cm, height=3*cm))
elements.append(Spacer(1, 2*cm))
elements.append(Paragraph("CATALOGUE DE PIÈCES ÉVOLUTIF HQS", styles["TitrePrincipal"]))
elements.append(Paragraph("Des solutions techniques sur mesure, fiables et prêtes à l’emploi", styles["SousTitre"]))
elements.append(PageBreak())

# --- PRÉSENTATION HQS ---
presentation = """
Basée en Savoie, HQS Solutions est un bureau d’étude technique spécialisé dans le développement de solutions clés en main pour les projets mécaniques et industriels.<br/><br/>
Nous accompagnons nos clients de la définition du besoin jusqu’à la livraison, en garantissant qualité, fiabilité et réactivité.<br/><br/>
Notre expertise en génie mécanique, combinée à un réseau de partenaires qualifiés, nous permet d’offrir des solutions sur mesure adaptées à chaque projet.<br/><br/>
<b>Nos valeurs :</b> Innovation – Rigueur – Réactivité – Accompagnement client.
"""
elements.append(Paragraph("<b>PRÉSENTATION HQS SOLUTIONS</b>", styles["TitreProduit"]))
elements.append(Paragraph(presentation, styles["Texte"]))
elements.append(PageBreak())

# --- PROCESSUS HQS ---
processus = [
    "1. Analyse du besoin client",
    "2. Cahier des charges personnalisé",
    "3. Modélisation & conception 3D",
    "4. Recherche de fabricant & production",
    "5. Contrôle qualité rigoureux",
    "6. Livraison et suivi client"
]
elements.append(Paragraph("<b>PROCESSUS HQS</b>", styles["TitreProduit"]))
for p in processus:
    elements.append(Paragraph(p, styles["Texte"]))
elements.append(PageBreak())

# --- FICHES PRODUITS ---
produits = [
    ("Attache Hublot", "ATHU1", "Attache robuste conçue pour garantir une fixation fiable et durable, idéale pour les environnements extérieurs.", "Résine + traitement UV", "Noir", "10 pièces"),
    ("Support Attache Hublot", "ATHU2", "Support conçu pour assurer la stabilité et la durabilité de l’attache hublot, même sous contraintes mécaniques répétées.", "Résine + traitement UV", "Noir", "10 pièces"),
    ("Corps Poignée", "COPOI1", "Élément principal de poignée, alliant ergonomie et robustesse. Idéal pour les applications nécessitant résistance et design fonctionnel.", "Résine + traitement UV", "Noir", "1 pièce"),
    ("Cran de Verrouillage Poignée", "COPOI2", "Cran de verrouillage précis assurant un maintien sûr et une manipulation fluide. Conçu pour une durabilité maximale.", "Résine + traitement UV", "Noir", "10 pièces"),
    ("Clips Cran de Verrouillage Poignée", "COPOI3", "Clips de maintien fiables assurant la cohésion de l’ensemble poignée. Faciles à installer et résistants aux contraintes mécaniques.", "Résine + traitement UV", "Noir", "10 pièces"),
]

for nom, ref, desc, mat, coul, qte in produits:
    data = [
        [Paragraph(f"<b>{nom}</b> – Réf. {ref}", styles["TitreProduit"])],
        [Paragraph(desc, styles["Texte"])],
        [Paragraph(f"<b>Matière :</b> {mat}<br/><b>Couleur :</b> {coul}<br/><b>Quantité minimum :</b> {qte}", styles["Carac"])]
    ]
    table = Table(data, colWidths=[16*cm])
    table.setStyle(TableStyle([
        ("BOX", (0,0), (-1,-1), 1, colors.HexColor("#004C97")),
        ("INNERPADDING", (0,0), (-1,-1), 6),
    ]))
    elements.append(table)
    elements.append(Spacer(1, 0.6*cm))
elements.append(PageBreak())

# --- PAGE CONTACT ---
contact = """
<b>HQS Solutions</b><br/>
105 avenue Combe de Savoie, 73460 Grésy-sur-Isère<br/>
📞 +33 6 52 98 57 86<br/>
✉ hqs.contacts@gmail.com<br/><br/>
Zone prévue pour QR Code (non inclus)
"""
elements.append(Paragraph("<b>CONTACT</b>", styles["TitreProduit"]))
elements.append(Paragraph(contact, styles["Texte"]))
elements.append(PageBreak())

# --- PAGE REMERCIEMENT ---
elements.append(Paragraph("<b>MERCI POUR VOTRE CONFIANCE</b>", styles["TitreProduit"]))
elements.append(Paragraph("HQS Solutions reste à votre disposition pour toute demande technique ou projet sur mesure.", styles["Texte"]))
elements.append(PageBreak())

# --- MENTIONS LÉGALES ---
mentions = """
© 2025 HQS Solutions – Tous droits réservés.<br/>
Toute reproduction, modification ou diffusion, même partielle, de ce catalogue est strictement interdite sans autorisation écrite de HQS Solutions.<br/>
Les informations techniques et visuelles contenues dans ce document sont données à titre indicatif et peuvent être modifiées sans préavis.
"""
elements.append(Paragraph("<b>MENTIONS LÉGALES</b>", styles["TitreProduit"]))
elements.append(Paragraph(mentions, styles["Texte"]))

# --- GÉNÉRATION DU PDF ---
doc.build(elements, onLaterPages=add_page_number, onFirstPage=add_page_number)

print("✅ Catalogue_HQS_Version_Claire.pdf généré avec succès.")