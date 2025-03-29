CREATE OR REPLACE FUNCTION inscription(
    p_nom VARCHAR,
    p_prenom VARCHAR,
    p_adresse TEXT,
    p_cp VARCHAR,
    p_ville VARCHAR,
    p_pays VARCHAR
) RETURNS INTEGER AS $$
DECLARE
    existing_code INTEGER;
    new_code INTEGER;
BEGIN
    -- Vérifie si le client existe déjà
    SELECT code INTO existing_code
    FROM clients
    WHERE nom = p_nom AND prenom = p_prenom AND adresse = p_adresse;

    IF FOUND THEN
        RETURN 0;
    ELSE
        -- Insère le nouveau client
        INSERT INTO clients (nom, prenom, adresse, cp, ville, pays, date_inscription)
        VALUES (p_nom, p_prenom, p_adresse, p_cp, p_ville, p_pays, CURRENT_DATE)
        RETURNING code INTO new_code;

        RETURN new_code;
    END IF;
END;
$$ LANGUAGE plpgsql;
