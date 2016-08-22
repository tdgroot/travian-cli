<?php

\Timpack\Travian\CommandRegistry::getInstance()
    ->register('\\Timpack\\Travian\\Command\\Account\\StatusCommand')
    ->register('\\Timpack\\Travian\\Command\\Account\\LoginCommand')
    ->register('\\Timpack\\Travian\\Command\\Account\\LogoutCommand')
    ->register('\\Timpack\\Travian\\Command\\Resource\\ListCommand')
    ->register('\\Timpack\\Travian\\Command\\Resource\\UpgradeCommand')
    ->register('\\Timpack\\Travian\\Command\\Village\\Building\\ListCommand')
    ->register('\\Timpack\\Travian\\Command\\Unit\\ListCommand');