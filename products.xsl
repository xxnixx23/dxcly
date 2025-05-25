<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <html>
            <xsl:attribute name="style">margin: 0; padding: 0; box-sizing: border-box; background:
        #181a1b; color: #fff; </xsl:attribute>
            <div class="products">
                <xsl:attribute name="style"> display: flex; align-items: center; gap: 2rem; padding:
        1rem 8.5rem; justify-content:center; font-family: Arial, Helvetica, sans-serif;</xsl:attribute>
                <xsl:for-each select="Products/Product">
                    <a>
                        <xsl:attribute name="href">
                            <xsl:value-of select="Link" />
                        </xsl:attribute>
                        <div class="product">
                            <xsl:attribute name="style">display: flex; flex-direction: column;
        align-items: center; gap: 1rem;</xsl:attribute>
                            <img src="{Location}" alt="{Name}" width="250px"
                                height="300px" />
                            <div class="product-details">
                                <span>
                                    <xsl:attribute name="style">text-transform: uppercase;
        font-weight: 600; font-size: 1rem;</xsl:attribute>
                                    <xsl:value-of select="Name" />
                                </span>
                                <br />
                                <br />
                                <span>
                                    <xsl:attribute name="style"> font-size: 0.8rem;</xsl:attribute>
                                    <xsl:value-of
                                        select="Price" />
                                </span>
                            </div>
                        </div>
                    </a>
                </xsl:for-each>

            </div>
        </html>
    </xsl:template>
</xsl:stylesheet>